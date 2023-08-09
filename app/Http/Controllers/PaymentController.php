<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Currency;
use App\Models\CustomSettings;
use App\Models\Gateways;
use App\Models\GatewayProducts;
use App\Models\PaymentPlans;
use App\Models\Setting;
use App\Models\HowitWorks;
use App\Models\Subscriptions as SubscriptionsModel;
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
use Laravel\Cashier\Subscription;

use App\Http\Controllers\Gateways\StripeController;
use App\Http\Controllers\Gateways\PaypalController;



/**
 * Controls ALL Payment actions
 */
class PaymentController extends Controller
{

    /**
     * Checks subscription table if given plan is active on user (already subscribed)
     */
    function isActiveSubscription($planId){
        // $plan->stripe_product_id != null
        $user = Auth::user();
        $userId=Auth::user()->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        if($activeSub != null){
            $activesubid = $activeSub->id;
        }else{
            $activesubid = 0; //id can't be zero, so this will be easy to check instead of null
        }
        return $activesubid == $planId;
    }


    public function startSubscriptionProcess($planId, $gatewayCode){
        $plan = PaymentPlans::where('id', $planId)->first();
        if($plan != null){
            if(self::isActiveSubscription($planId) == true){
                return back()->with(['message' => 'You already have subscription.Please cancel it before creating a new subscription.', 'type' => 'error']);
            }
            if($gatewayCode == 'stripe'){
                return StripeController::subscribe($planId, $plan);
            }
            if($gatewayCode == 'paypal'){
                return PaypalController::subscribe($planId, $plan);
            }
        }
        abort(404);
    }

    public static function cancelActiveSubscription(){
        $user = Auth::user();
        $userId=$user->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        if($activeSub == null){
            abort(404, 'Could not find any subscription. Please check your gateways panel.');
            return back()->with(['message' => 'Could not find any subscription. Please check your gateways panel.', 'type' => 'error']);
        }
        $gatewayCode = $activeSub->paid_with;
        if($gatewayCode == 'stripe'){
            return StripeController::subscribeCancel();
        }
        if($gatewayCode == 'paypal'){
            return PaypalController::subscribeCancel();
        }
        return back()->with(['message' => 'Could not cancel subscription. Please try again. If this error occures again, please update and migrate.', 'type' => 'error']);
    }


    public function startPrepaidPaymentProcess($planId, $gatewayCode){
        $plan = PaymentPlans::where('id', $planId)->first();
        if($plan != null){
            if($gatewayCode == 'stripe'){
                return StripeController::prepaid($planId, $plan);
            }
            if($gatewayCode == 'paypal'){
                return PaypalController::prepaid($planId, $plan);
            }
        }
        abort(404);
    }

    /**
     * Saves Membership plan product in all gateways.
     * @param planId ID of plan in PaymentPlans model.
     * @param productName Name of the product, plain text
     * @param price Price of product
     * @param frequency Time interval of subscription, month / annual
     * @param type Type of product subscription/one-time
     */
    public static function saveGatewayProducts($planId, $productName, $price, $frequency, $type){

        // error_log('Executing PaymentController->saveGatewayProducts() with :\n'.$planId."\n".$productName."\n".$price."\n".$frequency."\n".$type);
        
        // Replaced definitions here. Because if monthly or prepaid words change just updating here will be enough.
        $freq = $frequency == "monthly" ? "m" : "y"; // m => month | y => year
        $typ = $type == "prepaid" ? "o" : "s"; // o => one-time | s => subscription

        $gateways = Gateways::all();
        if($gateways != null){
            foreach($gateways as $gateway){
                if((int)$gateway->is_active == 1){
                    if($gateway->code == 'stripe'){
                        $tmp = StripeController::saveProduct($planId, $productName, $price, $freq, $typ);
                    }
                    if($gateway->code == 'paypal'){
                        $tmp = PaypalController::saveProduct($planId, $productName, $price, $freq, $typ);
                    }
                }
            }
        }else{
            error_log("Could not find any active gateways!\nPaymentController->saveGatewayProducts()");
            return back()->with(['message' => 'Please enable at least one gateway.', 'type' => 'error']);
        }
    }


    /**
     * This function checks status of user_orders status table.
     * 
     * If there is any "Waiting" order then checks its assigned gateway for order status.
     * 
     * If order is paid in gateway then updates user and order data
     */
    public static function checkForOngoingPayments(){


        return null;

    }


    public static function getSubscriptionDaysLeft(){
        $userId=Auth::user()->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        if($activeSub != null){
            $paid_with = $activeSub->paid_with;
            if($paid_with == 'stripe'){
                return StripeController::getSubscriptionDaysLeft();
            }
            if($paid_with == 'paypal'){
                return PaypalController::getSubscriptionDaysLeft();
            }
        }else{
            return null;
        }
    }

    
    public static function getSubscriptionRenewDate(){
        $userId=Auth::user()->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        if($activeSub != null){
            $paid_with = $activeSub->paid_with;
            if($paid_with == 'stripe'){
                return StripeController::getSubscriptionRenewDate();
            }
            if($paid_with == 'paypal'){
                return PaypalController::getSubscriptionRenewDate();
            }
        }else{
            return null;
        }
    }


    public static function getSubscriptionStatus(){
        $userId=Auth::user()->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        if($activeSub != null){
            switch ($activeSub->paid_with) {
                case 'stripe':
                    return StripeController::getSubscriptionStatus();
                    break;

                case 'paypal':
                    return PaypalController::getSubscriptionStatus();
                    break;

                default:
                    return false;
                    break;
            }
        }else{
            return false;
        }
    }

    public static function checkIfTrial(){
        $userId=Auth::user()->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        if($activeSub != null){
            switch ($activeSub->paid_with) {
                case 'stripe':
                    return StripeController::checkIfTrial();
                    break;

                case 'paypal':
                    return PaypalController::checkIfTrial();
                    break;

                default:
                    return false;
                    break;
            }
        }else{
            return false;
        }
    }

    /**
     * This functions matchs plan price id column with subscriptions table.
     * 
     * If there is any difference checks for activity and cancels plan from both gateway and user.
     * 
     * By this way, keeps subscriptions up-to-date.
     */
    public static function checkUnmatchingSubscriptions(){
        $userId=Auth::user()->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        if($activeSub != null){
            // Get list of current price id/billingplans from gatewayproducts
            $priceArray = GatewayProducts::all()->pluck('price_id')->toArray();
            if(in_array($activeSub->stripe_price, $priceArray) == true){
                // Do nothing. This is what we want.
            }else{
                // Cancel subscription
                try{
                    $tmp = self::cancelActiveSubscription();
                }catch(\Exception $ex){
                    error_log("PaymentController::checkUnmatchingSubscriptions()\n".$ex->getMessage());
                    // return back()->with(['message' => $ex->getMessage(), 'type' => 'error']);
                }
            }

            // Check if active subscription exists on gateway (by stripe_id / subscription id)
            $isValid = false;
            switch($activeSub->paid_with){
                case 'stripe':
                    $isValid = StripeController::getSubscriptionStatus();
                    break;
                case 'paypal':
                    $isValid = PaypalController::getSubscriptionStatus();
                    break;
            }
            
            // getSubscriptionStatus function is already called on subscription status file. BUT after functions which gives errors,
            // this needs priority, that's why we add here too. Also this function updates database as cancelled if can't find in gateway

        }
        
        // For some gateways we need to create orders first thats why we have so many Waiting order records. We must clean them.
        $orders = UserOrder::where([['status', '=', 'Waiting'], ['user_id', '=', $userId]])->get();
        foreach ($orders as $order) {
            $order->delete();
        }
        return null;
    }


    public static function deletePaymentPlan($id){

        // Get plan 
        $plan = PaymentPlans::where('id', $id)->first();
        if($plan != null){
            $planId = $plan->id;

            // Get related subscriptions
            $queryAnd = [['stripe_status', '=', 'active'  ], ['plan_id', '=', $planId]];
            $queryOr  = [['stripe_status', '=', 'trialing'], ['plan_id', '=', $planId]];
            $subscriptions = SubscriptionsModel::where($queryAnd)->orWhere($queryOr)->get();

            // Remove subcriptions one by one
            if($subscriptions != null){
                foreach ($subscriptions as $subscription) {
                    $subsId = $subscription->id;
                    switch ($subscription->paid_with) {
                        case 'stripe':
                            $tmp = StripeController::cancelSubscribedPlan($planId, $subsId);
                            break;
        
                        case 'paypal':
                            $tmp = PaypalController::cancelSubscribedPlan($planId, $subsId);
                            break;
                    }
                }
            }

            // Delete Plan
            $plan->delete();
            return back()->with(['message' => 'All subscriptions related to this plan has been cancelled. Plan is deleted.', 'type' => 'success']);
        }else{
            return back()->with(['message' => 'Couldn\'t find plan.', 'type' => 'error']);
        }

    }


}