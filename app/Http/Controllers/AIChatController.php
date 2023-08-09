<?php

namespace App\Http\Controllers;

use App\Models\OpenaiGeneratorChatCategory;
use App\Models\PaymentPlans;
use App\Models\Setting;
use App\Models\Subscriptions as SubscriptionsModel;
use App\Models\UserOpenaiChat;
use App\Models\UserOpenaiChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;

class AIChatController extends Controller
{
    protected $client;
    protected $settings;

    public function __construct()
    {
        //Settings
        $this->settings = Setting::first();
        // Fetch the Site Settings object with openai_api_secret
        $apiKeys = explode(',',$this->settings->openai_api_secret);
        $apiKey = $apiKeys[array_rand($apiKeys)];
        config(['openai.api_key' => $apiKey]);
    }

    public function openAIChatList(){
        $aiList = OpenaiGeneratorChatCategory::all();
        return view('panel.user.openai_chat.list', compact('aiList'));
    }


    public function search(Request $request){

        $categoryId = $request->category_id;
        $search = $request->search_word;

        $list = UserOpenaiChat::where('user_id', Auth::id())->where('openai_chat_category_id', $categoryId)->orderBy('updated_at', 'desc')->where('title', 'like', "%$search%");
        $list = $list->get();
        $html = view('panel.user.openai_chat.components.chat_sidebar_list', compact('list'))->render();
        return response()->json(compact('html'));
    }

    public function openAIChat($slug){
        $category = OpenaiGeneratorChatCategory::whereSlug($slug)->firstOrFail();
        $list = UserOpenaiChat::where('user_id', Auth::id())->where('openai_chat_category_id', $category->id)->orderBy('updated_at', 'desc');
        $list = $list->get();
        $chat = $list->first();
        $aiList = OpenaiGeneratorChatCategory::all();


        //FOR LOW
        $settings = Setting::first();
        // Fetch the Site Settings object with openai_api_secret
        $apiKeys = explode(',',$settings->openai_api_secret);
        $apiKey = $apiKeys[array_rand($apiKeys)];

        $len=strlen($apiKey);
        $parts[] = substr($apiKey, 0, $l[] = rand(1,$len-5));
        $parts[] = substr($apiKey, $l[0], $l[] = rand(1,$len-$l[0]-3));
        $parts[] = substr($apiKey, array_sum($l));

        $apikeyPart1 = base64_encode($parts[0]);
        $apikeyPart2 = base64_encode($parts[1]);
        $apikeyPart3 = base64_encode($parts[2]);
        $apiUrl = base64_encode('https://api.openai.com/v1/chat/completions');

        $lastThreeMessage = null;
        $chat_completions = null;

        if ($chat!= null){
            $lastThreeMessageQuery = $chat->messages()->whereNot('input', null)->orderBy('created_at', 'desc')->take(4);
            $lastThreeMessage = $lastThreeMessageQuery->get()->reverse();
            $category = OpenaiGeneratorChatCategory::where('id', $chat->openai_chat_category_id)->first();
            $chat_completions = str_replace(array("\r", "\n"), '', $category->chat_completions ) ?? null;

            if ( $chat_completions != null ) {
                $chat_completions = json_decode($chat_completions, true);
            }
        }



        //FOR LOW END

        return view('panel.user.openai_chat.chat', compact('category', 'list', 'chat', 'aiList',
        'apikeyPart1',
        'apikeyPart2',
        'apikeyPart3',
        'apiUrl',
        'lastThreeMessage',
        'chat_completions'
        ));
    }

    public function openChatAreaContainer(Request $request){
        $chat =  UserOpenaiChat::where('id', $request->chat_id)->first();
        $category = $chat->category;
        $html = view('panel.user.openai_chat.components.chat_area_container', compact('chat','category'))->render();
        return response()->json(compact('html'));
    }

    public function startNewChat(Request $request){
        $category = OpenaiGeneratorChatCategory::where('id', $request->category_id)->firstOrFail();
        $chat = new UserOpenaiChat();
        $chat->user_id = Auth::id();
        $chat->openai_chat_category_id = $category->id;
        $chat->title = $category->name.' Chat';
        $chat->total_credits = 0;
        $chat->total_words = 0;
        $chat->save();

        $message = new UserOpenaiChatMessage();
        $message->user_openai_chat_id = $chat->id;
        $message->user_id = Auth::id();
        $message->response = 'First Initiation';
        if ($category->role == 'default'){
            $output =  "Hi! I am $category->name, and I'm here to answer your all questions";
        }else{
            $output =  "Hi! I am $category->human_name, and I'm $category->role. $category->helps_with";
        }
        $message->output = $output;
        $message->hash = Str::random(256);
        $message->credits = 0;
        $message->words = 0;
        $message->save();

        $list = UserOpenaiChat::where('user_id', Auth::id())->where('openai_chat_category_id', $category->id)->orderBy('updated_at', 'desc')->get();

        $html = view('panel.user.openai_chat.components.chat_area_container', compact('chat', 'category' ))->render();
        $html2 = view('panel.user.openai_chat.components.chat_sidebar_list', compact('list', 'chat' ))->render();
        return response()->json(compact('html', 'html2'));
    }

    public function chatOutput(Request $request){
        if ($request->isMethod('get')){

            $user = Auth::user();
            // $subscribed = $user->subscriptions()->where('stripe_status', 'active')->orWhere('stripe_status', 'trialing')->first();
            $userId=$user->id;
            // Get current active subscription
            $subscribed = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
            if ($subscribed != null){
                $subscription = PaymentPlans::where('id', $subscribed->name)->first();
                if ($subscription!=null){
                    $chat_bot = $subscription->ai_name;
                }else{
                    $chat_bot = 'gpt-3.5-turbo';
                }
            }else{
                $chat_bot = 'gpt-3.5-turbo';
            }

            if ($chat_bot != 'gpt-3.5-turbo' or $chat_bot != 'gpt-4'){
                $chat_bot = 'gpt-3.5-turbo';
            }

            $chat_id = $request->chat_id;
            $message_id = $request->message_id;
            $user_id = Auth::id();

            $message = UserOpenaiChatMessage::whereId($message_id)->first();
            $prompt = $message->input;
            $chat = UserOpenaiChat::whereId($chat_id)->first();
            $lastThreeMessageQuery = $chat->messages()->whereNot('input', null)->orderBy('created_at', 'desc')->take(4);
            $lastThreeMessage = $lastThreeMessageQuery->get()->reverse();
            $i = 0;

            $category = OpenaiGeneratorChatCategory::where('id', $chat->openai_chat_category_id)->first();
            $chat_completions = str_replace(array("\r", "\n"), '', $category->chat_completions ) ?? null;

            if ( $chat_completions ) {

                $chat_completions = json_decode($chat_completions, true);

                foreach ($chat_completions as $item) {
                    $history[] = array(
                        "role" => $item["role"],
                        "content" => $item["content"]
                    );
                }

            } else {
                $history[] = ["role" => "system", "content" => "You are a helpful assistant."];
            }

            if (count($lastThreeMessage)>1){
                foreach ($lastThreeMessage as $threeMessage){
                    $history[] = ["role" => "user", "content" => $threeMessage->input];
                    if ($threeMessage->response != null){
                        $history[] = ["role" => "assistant", "content" => $threeMessage->response];
                    }
                }
            }else{
                $history[] = ["role" => "user", "content" => $prompt];
            }

            return response()->stream(function () use($prompt, $chat_id,  $message_id, $history, $chat_bot) {

                try{
                    $stream = OpenAI::chat()->createStreamed([
                        'model' => $chat_bot,
                        'messages' => $history,
                        "presence_penalty" => 0.6,
                        "frequency_penalty" => 0,
                    ]);
                } catch (\Exception $exception){
                    $messageError = 'Error from API call. Please try again. If error persists again please contact system administrator with this message '.$exception->getMessage();
                    echo "data: $messageError";
                    echo "\n\n";
                    ob_flush();
                    flush();
                    echo 'data: [DONE]';
                    echo "\n\n";
                    ob_flush();
                    flush();
                    usleep(50000);
                }



                $total_used_tokens = 0;
                $output = "";
                $responsedText = "";

                foreach ($stream as $response){
                    if (isset($response['choices'][0]['delta']['content'])){

                        $message = $response['choices'][0]['delta']['content'];
                        $messageFix = str_replace(["\r\n", "\r", "\n"], "<br/>", $message);
                        $output .= $messageFix;
                        $responsedText .= $message;
                        $total_used_tokens += countWords($message);
                        $string_length = Str::length($messageFix);
                        $needChars = 6000-$string_length;
                        $random_text = Str::random($needChars);

                        echo PHP_EOL;
                        echo 'data: ' . $messageFix.'/**'.$random_text."\n\n";
                        ob_flush();
                        flush();
                        usleep(5000);
                    }
                    if (connection_aborted()) {
                        break;
                    }
                }
                $message = UserOpenaiChatMessage::whereId($message_id)->first();
                $chat = UserOpenaiChat::whereId($chat_id)->first();
                $message->response = $responsedText;
                $message->output = $output;
                $message->hash = Str::random(256);
                $message->credits = $total_used_tokens;
                $message->words = 0;
                $message->save();

                $user = Auth::user();


                if ($user->remaining_words != -1){
                    $user->remaining_words -= $total_used_tokens;
                }

                if ($user->remaining_words<-1){
                    $user->remaining_words = 0;
                }
                $user->save();

                $chat->total_credits += $total_used_tokens;
                $chat->save();
                echo 'data: [DONE]';
                echo "\n\n";
                ob_flush();
                flush();
                usleep(50000);
            }, 200, [
                'Cache-Control' => 'no-cache',
                'X-Accel-Buffering' => 'no',
                'Content-Type' => 'text/event-stream',
            ]);
        }else{

            $chat = UserOpenaiChat::where('id', $request->chat_id)->first();
            $category = OpenaiGeneratorChatCategory::where('id', $request->category_id)->first();

            $user = Auth::user();
            if ($user->remaining_words != -1){
                if ($user->remaining_words <= 0){
                    $data = array(
                        'errors' => ['You have no credits left. Please consider upgrading your plan.'],
                    );
                    return response()->json($data, 419);
                }
            }
            if ($category->prompt_prefix != null){
                $prompt = "You will now play a character and respond as that character (You will never break character). Your name is $category->human_name.
            I want you to act as a $category->role.
            ".$category->prompt_prefix.' '.$request->prompt;
            }else{
                $prompt = $request->prompt;
            }



            $total_used_tokens = 0;

            $entry = new UserOpenaiChatMessage();
            $entry->user_id = Auth::id();
            $entry->user_openai_chat_id = $chat->id;
            $entry->input = $prompt;
            $entry->response = null;
            $entry->output = "(If you encounter this message, please attempt to send your message again. If the error persists beyond multiple attempts, please don't hesitate to contact us for assistance!)";
            $entry->hash = Str::random(256);
            $entry->credits = $total_used_tokens;
            $entry->words = 0;
            $entry->save();


            $user->save();

            $chat->total_credits += $total_used_tokens;
            $chat->save();

            $chat_id = $chat->id;
            $message_id = $entry->id;

            return response()->json(compact('chat_id', 'message_id'));
        }

    }
    public function deleteChat(Request $request){
        $chat_id = explode('_', $request->chat_id)[1];
        $chat = UserOpenaiChat::where('id', $chat_id)->first();
        $chat->delete();
    }

    public function renameChat(Request $request){
        $chat_id = explode('_', $request->chat_id)[1];
        $chat = UserOpenaiChat::where('id', $chat_id)->first();
        $chat->title = $request->title;
        $chat->save();
    }

    //Low
    public function lowChatSave(Request $request){
        $chat = UserOpenaiChat::where('id', $request->chat_id)->first();

        $message = new UserOpenaiChatMessage();
        $message->user_openai_chat_id = $chat->id;
        $message->user_id = Auth::id();
        $message->input = $request->input;
        $message->response = $request->response;
        $message->output = $request->response;
        $message->hash = Str::random(256);
        $message->credits = countWords($request->response);
        $message->words = countWords($request->response);
        $message->save();

        $user = Auth::user();

        if ($user->remaining_words != -1){
            $user->remaining_words -= $message->credits;
        }

        if ($user->remaining_words<-1){
            $user->remaining_words = 0;
        }
        $user->save();
    }



}
