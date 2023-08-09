<?php


namespace App\Http\Controllers;

use App\Models\OpenAIGenerator;
use App\Models\UserOpenai;
use App\Models\Setting;
use Illuminate\Http\Request;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GoogleTTSController extends Controller
{
    public function generateSpeech(Request $request)
    {

        $settings = Setting::first();

        //If gcs credentials are empty
        if (empty($settings->gcs_file) || empty($settings->gcs_name)) {
            $data = array(
                'errors' => ['Google TTS credentials wrong or missing!'],
            );
            return response()->json($data, 419);
        }

        //If speeches are null
        if ($request->speeches == '[]') {
            $data = array(
                'errors' => ['Please provide inputs.'],
            );
            return response()->json($data, 419);
        }

        try {
            $client = new TextToSpeechClient([
                'credentials' => storage_path($settings->gcs_file),
                'project_id' => $settings->gcs_name,
            ]);
        } catch (\Exception $e) {
            // Connection error occurred
            $data = array(
                'errors' => ["Failed to connect to Google TTS service: " . $e->getMessage()],
            );
            return response()->json($data, 419);
        }

        $speeches = json_decode($request->speeches, true);

        //Variables and arrays for store
        $wordCount = 0;
        $langsAndVoices = [];

        // Convert the text to SSML format
        // [{"voice":"eu-ES-Standard-A","lang":"eu-ES","content":""},{"voice":"eu-ES-Standard-A","lang":"eu-ES","content":""}]
        $ssml = '<speak>';
        foreach ($speeches as $speech) {


            $ssml .= sprintf(
                '<lang xml:lang="%3$s">
                    <prosody rate="%4$s">
                        <voice name="%1$s">%2$s</voice>
                        <break time="%5$ss"/>
                    </prosody>
                </lang>',
                $speech['voice'],
                $speech['content'],
                $speech['lang'],
                $speech['pace'],
                $speech['break'],
            );

            $langsAndVoices['language'][] = $speech['lang'];
            $langsAndVoices['voices'][] = $speech['voice'];

            $wordCount += countWords($speech['content']);
        }
        $ssml .= '</speak>';

        // Set the SSML as the synthesis input
        $synthesisInputSsml = (new SynthesisInput())
            ->setSsml($ssml);

        // Build the voice request, select the language code ("en-US") and the ssml voice gender

        $voice = (new VoiceSelectionParams())
            ->setLanguageCode('en-US')
            ->setSsmlGender(SsmlVoiceGender::FEMALE);


        // Effects profile
        // $effectsProfileId = 'telephony-class-application';

        // select the type of audio file you want returned
        $audioConfig = (new AudioConfig())
            ->setAudioEncoding(AudioEncoding::MP3);
        //->setEffectsProfileId(array($effectsProfileId));

        // Perform text-to-speech request on the SSML input with selected voice parameters and audio file type
        $response = $client->synthesizeSpeech($synthesisInputSsml, $voice, $audioConfig);
        $audioContent = $response->getAudioContent();

        $user = Auth::user();
        $ai = OpenAIGenerator::whereSlug('ai_voiceover')->first();

        $audioName = $user->id . '-' . Str::random(20) . '.mp3';
        Storage::disk('public')->put($audioName, $audioContent);

        $client->close();

        //Save in workbook
        $entry = new UserOpenai();
        $entry->title = $request->workbook_title;
        $entry->slug = Str::random(20) . Str::slug($user->fullName()) . '-workbook';
        $entry->user_id = $user->id;
        $entry->openai_id = $ai->id;
        $entry->input = $request->speeches;
        $entry->response = json_encode($langsAndVoices);
        $entry->output = $audioName;
        $entry->hash = Str::random(256);
        $entry->credits = $wordCount;
        $entry->words = $wordCount;
        $entry->save();

        if ($user->remaining_words != -1 and $user->remaining_words - $entry->credits < -1) {
            $user->remaining_words = 0;
        }


        if ($user->remaining_words != -1 and $user->remaining_words - $entry->credits > 0) {
            $user->remaining_words -= $wordCount;
        }

        if ($user->remaining_words < -1) {
            $user->remaining_words = 0;
        }
        $user->save();

        $userOpenai = UserOpenai::where('user_id', Auth::id())->where('openai_id', $ai->id)->orderBy('created_at', 'desc')->get();
        $openai = OpenAIGenerator::where('id', $ai->id)->first();
        $html2 = view('panel.user.openai.generator_components.generator_sidebar_table', compact('userOpenai', 'openai'))->render();
        return response()->json(compact('html2'));
    }


}
