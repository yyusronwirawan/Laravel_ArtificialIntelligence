<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Currency;
use App\Models\CustomSettings;
use App\Models\GatewayProducts;
use App\Models\Gateways;
use App\Models\OldGatewayProducts;
use App\Models\PaymentPlans;
use App\Models\Setting;
use App\Models\Subscriptions as SubscriptionsModel;
use App\Models\SubscriptionItems;
use App\Models\HowitWorks;
use App\Models\User;
use App\Models\UserAffiliate;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

/**
 * Controls ALL Payment actions of PayPal
 */
class PaypalController extends Controller
{

    /**
     * Reads GatewayProducts table and returns price id of the given plan
     */
    public static function getPaypalPriceId($planId){

        //check if plan exists
        $plan = PaymentPlans::where('id', $planId)->first();
        if($plan != null){
            $product = GatewayProducts::where(["plan_id" => $planId, "gateway_code" => "paypal"])->first();
            if($product != null){
                return $product->price_id;
            }else{
                return null;
            }
        }
        return null;
    }

    /**
     * Reads GatewayProducts table and returns price id of the given plan
     */
    public static function getPaypalProductId($planId){

        //check if plan exists
        $plan = PaymentPlans::where('id', $planId)->first();
        if($plan != null){
            $product = GatewayProducts::where(["plan_id" => $planId, "gateway_code" => "paypal"])->first();
            if($product != null){
                return $product->product_id;
            }else{
                return null;
            }
        }
        return null;
    }

    /**
     * Returns provider of Paypal
     */
    public static function getPaypalProvider(){

        $gateway = Gateways::where("code", "paypal")->first();
        if($gateway == null) { abort(404); } 
        $currency = Currency::where('id', $gateway->currency)->first()->code;
        $settings = Setting::first();
        $config = null;

        if(env('APP_ENV') == 'development'){
            $config = [
                'mode'    => 'sandbox',
                'sandbox' => [
                    'client_id'         => $gateway->sandbox_client_id,
                    'client_secret'     => $gateway->sandbox_client_secret,
                    'app_id'            => 'APP-80W284485P519543T',
                ],
            
                'payment_action' => 'Sale',
                'currency'       => $currency,
                'notify_url'     => $settings->site_url.'/paypal/notify',
                'locale'         => $gateway->currency_locale,
                'validate_ssl'   => false,
            ];
        }else{
            $config = [
                'mode'    => 'live',
                'live' => [
                    'client_id'         => $gateway->live_client_id,
                    'client_secret'     => $gateway->live_client_secret,
                    'app_id'            => $gateway->live_app_id,
                ],
            
                'payment_action' => 'Sale',
                'currency'       => $currency,
                'notify_url'     => $settings->site_url.'/paypal/notify',
                'locale'         => $gateway->currency_locale,
                'validate_ssl'   => true,
            ];
        }

        // error_log("getPaypalProvider() => config:\n".json_encode($config));

        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        return $provider;

    }


    public static function deactivateOtherPlans($provider, $productName){

        $plans = $provider->listPlans();
        if($plans != null){
            foreach($plans['plans'] as $plan){
                error_log(json_encode($plan));
                // if($plan[])
                // error_log($plan['name']." -> ".$plan['id']);
            }
        }else{
            error_log("deactivateOtherPlans() : List returned null");
        }
        
        return true;
    }


    public static function createBillingPlanData($productId, $productName, $trials, $currency, $interval, $price){

        if($trials == 0){
            $planData = [
                "product_id"        => $productId,
                "name"              => $productName,
                "description"       => "Billing Plan of ".$productName,
                "status"            => "ACTIVE",
                "billing_cycles"    => 
                [
                    [
                        "frequency" => 
                        [
                            "interval_unit"     => $interval,
                            "interval_count"    => 1
                        ],
                        "tenure_type"       => "REGULAR",
                        "sequence"          => 1,
                        "total_cycles"      => 0,
                        "pricing_scheme"    => 
                        [
                            "fixed_price"   => 
                            [
                                "value"         => strval($price),
                                "currency_code" => $currency
                            ]
                        ]
                    ]
                ],
                "payment_preferences" => 
                [
                    "auto_bill_outstanding" => true,
                    "setup_fee" => 
                    [
                        "value"         => "0",
                        "currency_code" => $currency
                    ],
                    "setup_fee_failure_action"  => "CANCEL",
                    "payment_failure_threshold" => 3
                ]
            ];
        }else{
            $planData = [
                "product_id"        => $productId,
                "name"              => $productName,
                "description"       => "Billing Plan of ".$productName,
                "status"            => "ACTIVE",
                "billing_cycles"    => 
                [
                    [
                        "frequency" => 
                        [
                            "interval_unit"     => 'DAY',
                            "interval_count"    => 1
                        ],
                        "tenure_type"       => "TRIAL",
                        "sequence"          => 1,
                        "total_cycles"      => $trials,
                        "pricing_scheme"    => 
                        [
                            "fixed_price"   => 
                            [
                                "value"         => 0,
                                "currency_code" => $currency
                            ]
                        ]
                    ],
                    [
                        "frequency" => 
                        [
                            "interval_unit"     => $interval,
                            "interval_count"    => 1
                        ],
                        "tenure_type"       => "REGULAR",
                        "sequence"          => 2,
                        "total_cycles"      => 0,
                        "pricing_scheme"    => 
                        [
                            "fixed_price"   => 
                            [
                                "value"         => strval($price),
                                "currency_code" => $currency
                            ]
                        ]
                    ]
                ],
                "payment_preferences" => 
                [
                    "auto_bill_outstanding" => true,
                    "setup_fee" => 
                    [
                        "value"         => "0",
                        "currency_code" => $currency
                    ],
                    "setup_fee_failure_action"  => "CANCEL",
                    "payment_failure_threshold" => 3
                ]
            ];

            // "taxes" => 
            //     [
            //         "percentage" => "0",
            //         "inclusive" => false
            //     ]
        }

        return $planData;
    }


    /**
     * Saves Membership plan product in paypal gateway.
     * @param planId ID of plan in PaymentPlans model.
     * @param productName Name of the product, plain text
     * @param price Price of product
     * @param frequency Time interval of subscription, month / annual
     * @param type Type of product subscription/one-time
     */
    public static function saveProduct($planId, $productName, $price, $frequency, $type, $incomingProvider = null){

        try{

        $gateway = Gateways::where("code", "paypal")->first();
        if($gateway == null) { abort(404); } 
        $currency = Currency::where('id', $gateway->currency)->first()->code;

        $provider = $incomingProvider ?? self::getPaypalProvider();

        $plan = PaymentPlans::where('id', $planId)->first();

        $product = null;

        if($gateway->mode == 'sandbox'){
            if(env('APP_ENV') != 'development'){
                return back()->with(['message' => 'Paypal Save cancelled! Please set mode to development!', 'type' => 'error']);
            }
        }
        
        $oldProductId = null;

        //check if product exists
        $productData = GatewayProducts::where(["plan_id" => $planId, "gateway_code" => "paypal"])->first();
        if($productData != null){

            // Create product in every situation. maybe user updated paypal credentials.

            if($productData->product_id != null){ // && $productName != null
                //Product has been created before
                $oldProductId = $productData->product_id;
            }else{
                //Product has NOT been created before but record exists. Create new product and update record.
            }

            $data = [
                "name"          => $productName,
                "description"   => $productName,
                "type"          => "SERVICE",
                "category"      => "SOFTWARE"
            ];
                
            $request_id = 'create-product-'.time();
                
            $newProduct = $provider->createProduct($data, $request_id);

            $productData->product_id = $newProduct['id'];
            $productData->plan_name = $productName;
            $productData->save();


            $product = $productData;
        }else{

            $data = [
                "name"          => $productName,
                "description"   => $productName,
                "type"          => "SERVICE",
                "category"      => "SOFTWARE"
            ];
              
            $request_id = 'create-product-'.time();
              
            $newProduct = $provider->createProduct($data, $request_id);

            $product = new GatewayProducts();
            $product->plan_id = $planId;
            $product->plan_name = $productName;
            $product->gateway_code = "paypal";
            $product->gateway_title = "PayPal";
            $product->product_id = $newProduct['id'];
            $product->save();
        }

        //check if price exists
        if($product->price_id != null){
            //Price exists - here price_id is plan_id in PayPal ( Billing plans id )

            // One-Time price
            if($type == "o"){
                
                // Paypal handles one time prices with orders, so we do not need to set anything for one-time payments.
                $product->price_id = __('Not Needed');
                $product->save();
                
            }else{
                // Subscription

                
                // Deactivate old billing plan --> Moved to updateUserData()
                $oldBillingPlanId = $product->price_id;
                // $oldBillingPlan = $provider->deactivatePlan($oldBillingPlanId);

                // create new billing plan with new values
                $interval = $frequency == "m" ? 'MONTH' : 'YEAR';

                if($plan->trial_days != "undefined"){
                    $trials = $plan->trial_days ?? 0;
                }else{
                    $trials = 0;
                }

                $planData = self::createBillingPlanData($product->product_id, $productName, $trials, $currency, $interval, $price);

                // This line is not in docs. but required in execution. Needed ~5 hours to fix.
                $request_id = 'create-plan-'.time();

                $billingPlan = $provider->createPlan($planData, $request_id);

                $product->price_id = $billingPlan['id'];
                $product->save();

                $history = new OldGatewayProducts();
                $history->plan_id = $planId;
                $history->plan_name = $productName;
                $history->gateway_code = 'paypal';
                $history->product_id = $product->product_id;
                $history->old_product_id = $oldProductId;
                $history->old_price_id = $oldBillingPlanId;
                $history->new_price_id = $billingPlan['id'];
                $history->status = 'check';
                $history->save();

                $tmp = self::updateUserData();

                ///////////// To support old entries and prevent update issues on trial and non-trial areas
                ///////////// update system is cancelled. instead we are going to create new ones, deactivate old ones and replace them.

            }

        }else{
            // price_id is null so we need to create plans

            // One-Time price
            if($type == "o"){
                
                // Paypal handles one time prices with orders, so we do not need to set anything for one-time payments.
                $product->price_id = __('Not Needed');
                $product->save();
                
            }else{
                // Subscription

                // to subscribe, first create billing plan. then subscribe with it. so price_id is billing_plan_id
                // subscribe has different id and logic in paypal

                $interval = $frequency == "m" ? 'MONTH' : 'YEAR';

                $trials = $plan->trial_days ?? 0;
                
                $planData = self::createBillingPlanData($product->product_id, $productName, $trials, $currency, $interval, $price);

                // This line is not in docs. but required in execution. Needed ~5 hours to fix.
                $request_id = 'create-plan-'.time();

                $billingPlan = $provider->createPlan($planData, $request_id);

                $product->price_id = $billingPlan['id'];
                $product->save();
            }
        }

    }catch(\Exception $ex){
        error_log("PaypalController::saveProduct()\n".$ex->getMessage());
        return back()->with(['message' => $ex->getMessage(), 'type' => 'error']);
    }


    } // saveProduct()



    /**
     * Used to generate new product id and price id of all saved membership plans in paypal gateway.
     */
    public static function saveAllProducts(){
        try{

            $gateway = Gateways::where("code", "paypal")->first();
            if($gateway == null) { 
                return back()->with(['message' => __('Please enable PayPal'), 'type' => 'error']);
                abort(404); } 

            // Get all membership plans

            $provider = self::getPaypalProvider();

            $plans = PaymentPlans::where('active', 1)->get();

            foreach ($plans as $plan) {
                // Replaced definitions here. Because if monthly or prepaid words change just updating here will be enough.
                $freq = $plan->frequency == "monthly" ? "m" : "y"; // m => month | y => year
                $typ = $plan->type == "prepaid" ? "o" : "s"; // o => one-time | s => subscription

                self::saveProduct($plan->id, $plan->name, $plan->price, $freq, $typ, $provider);
            }

        }catch(\Exception $ex){
            error_log("PaypalController::saveAllProducts()\n".$ex->getMessage());
            return back()->with(['message' => $ex->getMessage(), 'type' => 'error']);
        }

    }


    /**
     * Displays Payment Page of PayPal gateway for prepaid plans.
     */
    public static function prepaid($planId, $plan, $incomingException = null){

        $gateway = Gateways::where("code", "paypal")->first();
        if($gateway == null) { abort(404); } 

        $currency = Currency::where('id', $gateway->currency)->first()->code;

        $provider = self::getPaypalProvider();

        $orderId = null;
        $exception = $incomingException;

        try {
            if(self::getPaypalProductId($planId) == null){
                $exception = "Product ID is not set!";
            }
            
        } catch (\Exception $th) {
            $exception = Str::before($th->getMessage(),':');
        }
        
        return view('panel.user.payment.prepaid.payWithPaypal', compact('plan', 'orderId', 'gateway', 'exception', 'currency'));
    }



    public function createPayPalOrder(Request $request){

        $plan = PaymentPlans::where('id', $request->plan_id)->first();
        $user = Auth::user();
        $settings = Setting::first();

        $provider = self::getPaypalProvider();

        $data = [
            "intent" => "CAPTURE",
            "purchase_units" => 
            [
                [
                    "amount" => 
                    [
                        "currency_code" => $request->currency,
                        "value" => strval($plan->price)
                    ]
                ]
            ]
        ];
        
        $order = $provider->createOrder($data);

        $orderId = $order['id'];

        $payment = new UserOrder();
        $payment->order_id = $orderId;
        $payment->plan_id = $plan->id;
        $payment->type = 'prepaid';
        $payment->user_id = $user->id;
        $payment->payment_type = 'PayPal';
        $payment->price = $plan->price;
        $payment->affiliate_earnings = ($plan->price*$settings->affiliate_commission_percentage)/100;
        $payment->status = 'Waiting';
        $payment->country = $user->country ?? 'Unknown';
        $payment->save();


        return $order;


    }


    public function capturePayPalOrder(Request $request){

        try{
            $orderId = $request->orderID;

            $provider = self::getPaypalProvider();

            $order = $provider->capturePaymentOrder($orderId);

            $payment = UserOrder::where('order_id', $orderId)->first();

            if($payment != null){

                $payment->status = 'Success';
                $payment->save();

                $plan = PaymentPlans::where('id', $payment->plan_id)->first();

                $user = Auth::user();

                $user->remaining_words += $plan->total_words;
                $user->remaining_images += $plan->total_images;
                $user->save();

                createActivity($user->id, 'Purchased', $plan->name.' Token Pack', null);

            }else{
                error_log("PaypalController::capturePayPalOrder(): Could not find required payment order!");
            }

            return $order;

        } catch (\Exception $th) {
            error_log($th->getMessage());
            return Str::before($th->getMessage(),':');
        }


    }



    /**
     * Displays Payment Page of Stripe gateway.
     */
    public static function subscribe($planId, $plan, $incomingException = null){

        // $provider = self::getPaypalProvider();
        $gateway = Gateways::where("code", "paypal")->first();
        if($gateway == null) { abort(404); } 

        $settings = Setting::first();

        $user = Auth::user();

        $subscriptionId = null;
        $exception = $incomingException;
        $orderId = Str::random(12);
        $productId = self::getPaypalProductId($planId);
        $billingPlanId = self::getPaypalPriceId($planId);

        try {
            if($productId == null){
                $exception = "Product ID is not set!";
            }
            
            if($billingPlanId == null){
                $exception = "Plan ID is not set!";
            }

            
            if($exception == null){
                $payment = new UserOrder();
                $payment->order_id = $orderId;
                $payment->plan_id = $planId;
                $payment->user_id = $user->id;
                $payment->payment_type = 'PayPal';
                $payment->price = $plan->price;
                $payment->affiliate_earnings = ($plan->price*$settings->affiliate_commission_percentage)/100;
                $payment->status = 'Waiting';
                $payment->country = $user->country ?? 'Unknown';
                $payment->save();
            }

        } catch (\Exception $th) {
            $exception = Str::before($th->getMessage(),':');
        }
        
        return view('panel.user.payment.subscription.payWithPaypal', compact('plan', 'billingPlanId', 'exception', 'orderId', 'productId', 'gateway', 'planId'));
    }



    public function approvePaypalSubscription(Request $request){

        try{
            $orderId = $request->orderId;
            $paypalSubscriptionID = $request->paypalSubscriptionID;
            $billingPlanId = $request->billingPlanId;
            $productId = $request->productId;
            $planId = $request->planId;
            
            // return ["result" => "orderId: ".$orderId." | paypalSubscriptionID".$paypalSubscriptionID." | billingPlanId".$billingPlanId." | productId".$productId." | planId".$planId];

            $provider = self::getPaypalProvider();

            $productId = self::getPaypalProductId($planId);

            $plan = PaymentPlans::where('id', $planId)->first();

            $payment = UserOrder::where('order_id', $orderId)->first();

            $user = Auth::user();

            if($payment != null){

                $subscription = new SubscriptionsModel();
                $subscription->user_id = $user->id;
                $subscription->name = $planId;
                $subscription->stripe_id = $paypalSubscriptionID;
                $subscription->stripe_status = 'active';
                $subscription->stripe_price = $billingPlanId;
                $subscription->quantity = 1;
                $subscription->plan_id = $planId;
                $subscription->paid_with = 'paypal';
                $subscription->save();


                $subscriptionItem = new SubscriptionItems();
                $subscriptionItem->subscription_id = $subscription->id;
                $subscriptionItem->stripe_id = $orderId;
                $subscriptionItem->stripe_product = $productId;
                $subscriptionItem->stripe_price = $billingPlanId;
                $subscriptionItem->quantity = 1;
                $subscriptionItem->save();


                // $payment = UserOrder::where('order_id', $orderId)->first();
                $payment->status = 'Success';
                $payment->save();
        
                $user->remaining_words += $plan->total_words;
                $user->remaining_images += $plan->total_images;
                $user->save();
        
                createActivity($user->id, 'Subscribed', $plan->name.' Plan', null);

                return ["result" => "OK"];

                // return redirect()->route('dashboard.index')->with(['message' => 'Thank you for your purchase. Enjoy your remaining words and images.', 'type' => 'success']);

            }else{
                $msg="PaypalController::approvePaypalSubscription(): Could not find required payment order!";
                error_log($msg);
                return ["result" => $msg];
            }

            

        } catch (\Exception $th) {
            error_log("PaypalController::approvePaypalSubscription(): ".$th->getMessage());
            return ["result" => Str::before($th->getMessage(),':')];
            // return Str::before($th->getMessage(),':');
        }

        return ["result" => "Error"];
    }


    /**
     * Cancels current subscription plan
     */
    public static function subscribeCancel(){

        $user = Auth::user();

        $provider = self::getPaypalProvider();

        $userId=$user->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();

        if($activeSub != null){
            $plan = PaymentPlans::where('id', $activeSub->plan_id)->first();

            $response = $provider->cancelSubscription($activeSub->stripe_id, 'Not satisfied with the service');

            if($response == ""){
                $activeSub->stripe_status = "cancelled";
                $activeSub->ends_at = \Carbon\Carbon::now();
                $activeSub->save();

                $recent_words = $user->remaining_words - $plan->total_words;
                $recent_images = $user->remaining_images - $plan->total_images;


                $user->remaining_words = $recent_words < 0 ? 0 : $recent_words;
                $user->remaining_images = $recent_images < 0 ? 0 : $recent_images;
                $user->save();

                createActivity($user->id, 'Cancelled', 'Subscription plan', null);

                return back()->with(['message' => 'Your subscription is cancelled succesfully.', 'type' => 'success']);
            }else{
                return back()->with(['message' => 'Your subscription could not cancelled.', 'type' => 'error']);
            }

            


        }
        
        return back()->with(['message' => 'Could not find active subscription. Nothing changed!', 'type' => 'error']);
    }



    public static function getSubscriptionDaysLeft(){
        $provider = self::getPaypalProvider();
        $userId=Auth::user()->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        if($activeSub != null){
            $subscription = $provider->showSubscriptionDetails($activeSub->stripe_id);
            if(!isset($subscription['error'])){
                //if user is in trial
                if(isset($subscription['billing_info']['cycle_executions'][0]['tenure_type'])){
                    if($subscription['billing_info']['cycle_executions'][0]['tenure_type'] == 'TRIAL'){
                        return $subscription['billing_info']['cycle_executions'][0]['cycles_remaining'];
                    }else{
                        if(isset($subscription['billing_info']['next_billing_time'])){
                            return \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($subscription['billing_info']['next_billing_time']));
                        }else{
                            $activeSub->stripe_status = "cancelled";
                            $activeSub->ends_at = \Carbon\Carbon::now();
                            $activeSub->save();
                            return \Carbon\Carbon::now()->format('F jS, Y');
                        }
                    }
                }
            }else{
                error_log("PaypalController::getSubscriptionStatus() :\n".json_encode($subscription));
            }

        }
        return null;
    }

    public static function checkIfTrial(){
        $provider = self::getPaypalProvider();
        $userId=Auth::user()->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        if($activeSub != null){
            $subscription = $provider->showSubscriptionDetails($activeSub->stripe_id);
            if(isset($subscription['error'])){
                error_log("PaypalController::getSubscriptionStatus() :\n".json_encode($subscription));
                return back()->with(['message' => 'PayPal Gateway : '.$subscription['error']['message'], 'type' => 'error']);
            }
            if(isset($subscription['billing_info']['cycle_executions'][0]['tenure_type'])){
                if($subscription['billing_info']['cycle_executions'][0]['tenure_type'] == 'TRIAL'){
                    return true;
                }
            }
        }
        return false;
    }

    public static function getSubscriptionDetails(){
        $provider = self::getPaypalProvider();
        $userId=Auth::user()->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        if($activeSub != null){
            return $provider->showSubscriptionDetails($activeSub->stripe_id);
        }
        return null;
    }

    

    public static function getSubscriptionRenewDate(){
        $provider = self::getPaypalProvider();
        $userId=Auth::user()->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        if($activeSub != null){
            $subscription = $provider->showSubscriptionDetails($activeSub->stripe_id);

            if(isset($subscription['error'])){
                error_log("PaypalController::getSubscriptionStatus() :\n".json_encode($subscription));
                return back()->with(['message' => 'PayPal Gateway : '.$subscription['error']['message'], 'type' => 'error']);
            }

            if($subscription['billing_info']['next_billing_time']){
                return \Carbon\Carbon::parse($subscription['billing_info']['next_billing_time'])->format('F jS, Y');
            }else{
                $activeSub->stripe_status = "cancelled";
                $activeSub->ends_at = \Carbon\Carbon::now();
                $activeSub->save();
                return \Carbon\Carbon::now()->format('F jS, Y');
            }

        }
        return null;
    }


    /**
     * Checks status directly from gateway and updates database if cancelled or suspended.
     */
    public static function getSubscriptionStatus(){
        $provider = self::getPaypalProvider();
        $userId=Auth::user()->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        if($activeSub != null){
            $subscription = $provider->showSubscriptionDetails($activeSub->stripe_id);

            if(isset($subscription['error'])){
                error_log("PaypalController::getSubscriptionStatus() :\n".json_encode($subscription));
                return back()->with(['message' => 'PayPal Gateway : '.$subscription['error']['message'], 'type' => 'error']);
            }
            
            if ($subscription['status'] == 'ACTIVE'){
                return true;
            }else{
                $activeSub->stripe_status = 'cancelled';
                $activeSub->ends_at = \Carbon\Carbon::now();
                $activeSub->save();
                return false;
            }
        }
        return null;
    }


    /**
     * Since price id (billing plan) is changed, we must update user data, i.e cancel current subscriptions.
     */
    public static function updateUserData(){

        $history = OldGatewayProducts::where([
            "gateway_code" => 'paypal',
            "status" => 'check'
        ])->get();

        if($history != null){

            $provider = self::getPaypalProvider();

            foreach ($history as $record) {

                // check record current status from gateway
                $lookingFor = $record->old_price_id; // billingPlan id in paypal
                
                // if active disable it
                $oldBillingPlan = $provider->deactivatePlan($lookingFor);
                
                if($oldBillingPlan == ""){
                    //deactivated billing plan from gateway
                }else{
                    error_log("PaypalController::updateUserData():\n".json_encode($oldBillingPlan));
                }

                // search subscriptions for record
                $subs = SubscriptionsModel::where([
                    'stripe_status' => 'active',
                    'stripe_price'  => $lookingFor 
                ])->get();

                if($subs != null){
                    foreach ($subs as $sub) {
                        // if found get order id
                        $orderId = $sub->stripe_id;

                        // cancel subscription order from gateway
                        $response = $provider->cancelSubscription($orderId, 'New plan created by admin.');

                        // cancel subscription from our database
                        $sub->stripe_status = 'cancelled';
                        $sub->ends_at = \Carbon\Carbon::now();
                        $sub->save();
                    }
                }
                
                $record->status = 'checked';
                $record->save();

            }
        }

    }




    public static function cancelSubscribedPlan($planId, $subsId){

        $user = Auth::user();

        $provider = self::getPaypalProvider();

        $currentSubscription = SubscriptionsModel::where('id', $subsId)->first();

        if($currentSubscription != null){
            $plan = PaymentPlans::where('id', $planId)->first();

            $response = $provider->cancelSubscription($currentSubscription->stripe_id, 'Plan deleted by admin.');

            if($response == ""){
                $currentSubscription->stripe_status = "cancelled";
                $currentSubscription->ends_at = \Carbon\Carbon::now();
                $currentSubscription->save();
                return true;
            }

        }

        return false;
    }


}