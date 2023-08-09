<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GatewayController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Gateways\PaypalController;
use App\Jobs\SendInviteEmail;
use App\Models\Activity;
use App\Models\Gateways;
use App\Models\OpenAIGenerator;
use App\Models\OpenaiGeneratorFilter;
use App\Models\PaymentPlans;
use App\Models\Setting;
use App\Models\Subscriptions as SubscriptionsModel;
use App\Models\User;
use App\Models\UserAffiliate;
use App\Models\UserFavorite;
use App\Models\UserOpenai;
use App\Models\UserOpenaiChat;
use App\Models\UserOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Laravel\Cashier\Payment;
use Stripe\PaymentIntent;
use Stripe\Plan;

class UserController extends Controller
{
    public function redirect(){
        if (Auth::user()->type == 'admin'){
            return redirect()->route('dashboard.admin.index');
        }else{
            return redirect()->route('dashboard.user.index');

        }
    }

    public function index(){
        // $ongoingPayments = self::prepareOngoingPaymentsWarning();
        $ongoingPayments=null;
        // $ongoingPayments=PaypalController::getSubscriptionDetails();
        // $user = Auth::user();
        $tmp = PaymentController::checkUnmatchingSubscriptions();
        // $ongoingPayments = PaymentController::checkUnmatchingSubscriptions();


        //User Dashboard Variables;


        return view('panel.user.dashboard', compact('ongoingPayments')); //
    }

    function prepareOngoingPaymentsWarning(){
        $ongoingPayments = PaymentController::checkForOngoingPayments();
        if($ongoingPayments != null){
            return $ongoingPayments;
        }
        return null;
    }

    public function openAIList(){
        $list = OpenAIGenerator::all();
        $filters = OpenaiGeneratorFilter::get();
        return view('panel.user.openai.list', compact('list', 'filters'));
    }

    public function openAIFavoritesList(){
        return view('panel.user.openai.list_favorites');
    }

    public function openAIFavorite(Request $request){
        $exists =  isFavorited($request->id);
        if ($exists){
            $favorite = UserFavorite::where('openai_id', $request->id)->where('user_id', Auth::id())->first();
            $favorite->delete();
            $html = '<svg width="16" height="15" viewBox="0 0 16 15" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path d="M7.99989 11.8333L3.88522 13.9966L4.67122 9.41459L1.33789 6.16993L5.93789 5.50326L7.99522 1.33459L10.0526 5.50326L14.6526 6.16993L11.3192 9.41459L12.1052 13.9966L7.99989 11.8333Z" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>';
        }else{
            $favorite = new UserFavorite();
            $favorite->user_id = Auth::id();
            $favorite->openai_id = $request->id;
            $favorite->save();
            $html = '<svg width="16" height="15" viewBox="0 0 16 15" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path d="M7.99989 11.8333L3.88522 13.9966L4.67122 9.41459L1.33789 6.16993L5.93789 5.50326L7.99522 1.33459L10.0526 5.50326L14.6526 6.16993L11.3192 9.41459L12.1052 13.9966L7.99989 11.8333Z" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>';

        }
        return response()->json(compact('html'));
    }

    public function openAIGenerator($slug){
        $openai = OpenAIGenerator::whereSlug($slug)->firstOrFail();
        $userOpenai = UserOpenai::where('user_id', Auth::id())->where('openai_id', $openai->id)->orderBy('created_at', 'desc')->get();
        return view('panel.user.openai.generator', compact('openai', 'userOpenai'));
    }

    public function openAIGeneratorWorkbook($slug){
        $openai = OpenAIGenerator::whereSlug($slug)->firstOrFail();
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
        return view('panel.user.openai.generator_workbook', compact('openai',
            'apikeyPart1',
            'apikeyPart2',
            'apikeyPart3',
            'apiUrl',
        ));
    }

    public function openAIGeneratorWorkbookSave(Request $request){
        $workbook = UserOpenai::where('slug', $request->workbook_slug)->firstOrFail();
        $workbook->output = $request->workbook_text;
        $workbook->title = $request->workbook_title;
        $workbook->save();
        return response()->json([], 200);
    }

    //Chat
    public function openAIChat(){
        $chat = Auth::user()->openaiChat;
        return view('panel.user.openai.chat', compact('chat'));
    }

    //Profile user settings
    public function userSettings(){
        $user = Auth::user();
        return view('panel.user.settings.index', compact('user'));
    }

    public function userSettingsSave(Request $request){
        $user = Auth::user();
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->phone = $request->phone;
        $user->country = $request->country;

        if ($request->old_password != null){
                $validated = $request->validateWithBag('updatePassword', [
                    'old_password' => ['required', 'current_password'],
                    'new_password' => ['required', Password::defaults(), 'confirmed'],
                ]);

                $user->password = Hash::make($request->new_password);

        }

        if ($request->hasFile('avatar')){
            $path = 'upload/images/avatar/';
            $image = $request->file('avatar');
            $image_name = Str::random(4).'-'.Str::slug($user->fullName()).'-avatar.'.$image->getClientOriginalExtension();

            //Resim uzantı kontrolü
            $imageTypes = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
            if (!in_array(Str::lower($image->getClientOriginalExtension()), $imageTypes)){
                $data = array(
                    'errors' => ['The file extension must be jpg, jpeg, png, webp or svg.'],
                );
                return response()->json($data, 419);
            }

            $image->move($path, $image_name);

            $user->avatar = $path.$image_name;
        }

        createActivity($user->id, 'Updated', 'Profile Information', null);
        $user->save();
    }

    //Purchase
    public function subscriptionPlans() {

        //check if any payment gateway enabled
        $activeGateways = Gateways::where("is_active", 1)->get();
        if($activeGateways->count() > 0){
            $is_active_gateway = 1;
        }else{
            $is_active_gateway = 0;
        }

        //check if any subscription is active
        $userId=Auth::user()->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        $activesubid = 0; //id can't be zero, so this will be easy to check
        if($activeSub != null){
            $activesubid = $activeSub->plan_id;
        }

        $plans = PaymentPlans::where('type', 'subscription')->where('active', 1)->get();
        $prepaidplans = PaymentPlans::where('type', 'prepaid')->where('active', 1)->get();
        return view('panel.user.payment.subscriptionPlans', compact('plans', 'prepaidplans', 'is_active_gateway', 'activeGateways', 'activesubid'));
    }




    //Invoice - Billing
    public function invoiceList(){
        $user = Auth::user();
        $list = $user->orders;
        return view('panel.user.orders.index', compact('list'));
    }

    public function invoiceSingle($order_id){
        $user = Auth::user();
        $invoice = UserOrder::where('order_id', $order_id)->firstOrFail();
        return view('panel.user.orders.invoice', compact('invoice'));
    }

    public function documentsAll(){
        $items = Auth::user()->openai()->orderBy('created_at', 'desc')->paginate(50);
        return view('panel.user.openai.documents', compact('items'));
    }

    public function documentsSingle($slug){
        $workbook = UserOpenai::where('slug', $slug)->first();
        $openai = $workbook->generator;
        return view('panel.user.openai.documents_workbook', compact('workbook', 'openai'));
    }

    public function documentsDelete($slug){
        $workbook = UserOpenai::where('slug', $slug)->first();
        $workbook->delete();
        return redirect()->route('dashboard.user.openai.documents.all')->with(['message' => 'Document deleted succesfuly', 'type' => 'success']);

    }

    public function documentsImageDelete($slug){
        $workbook = UserOpenai::where('slug', $slug)->first();
        $workbook->delete();
        return back()->with(['message' => 'Deleted succesfuly', 'type' => 'success']);

    }

    //Affiliates
    public function affiliatesList(){
        $user = Auth::user();
        $list = $user->affiliates;
        $list2 = $user->withdrawals;
        $totalEarnings = 0;
        foreach ($list as $affOrders){
            $totalEarnings += $affOrders->orders->sum('affiliate_earnings');
        }
        $totalWithdrawal = 0;
        foreach($list2 as $affWithdrawal){
            $totalWithdrawal += $affWithdrawal->amount;
        }
        return view('panel.user.affiliate.index', compact('list', 'list2', 'totalEarnings', 'totalWithdrawal'));
    }

    public function affiliatesListSendInvitation(Request $request){
        $user = Auth::user();

        $sendTo = $request->to_mail;

        dispatch(new SendInviteEmail($user, $sendTo));

        return response()->json([], 200);
    }

    public function affiliatesListSendRequest(Request $request){
        $user = Auth::user();
        $list = $user->affiliates;
        $list2 = $user->withdrawals;

        $totalEarnings = 0;
        foreach ($list as $affOrders){
            $totalEarnings += $affOrders->orders->sum('affiliate_earnings');
        }
        $totalWithdrawal = 0;
        foreach($list2 as $affWithdrawal){
            $totalWithdrawal += $affWithdrawal->amount;
        }
        if ($totalEarnings - $totalWithdrawal >= $request->amount){
            $user->affiliate_bank_account = $request->affiliate_bank_account;
            $user->save();
            $withdrawalReq = new UserAffiliate();
            $withdrawalReq->user_id = Auth::id();
            $withdrawalReq->amount = $request->amount;
            $withdrawalReq->save();

            createActivity($user->id, 'Sent', 'Affiliate Withdraw Request', route('dashboard.admin.affiliates.index'));

        }else{
            return response()->json(['error' => 'ERROR'], 411);
        }
    }


}
