<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateways\StripeController;
use App\Http\Controllers\Gateways\PaypalController;
use App\Models\Activity;
use App\Models\Currency;
use App\Models\CustomSettings;
use App\Models\Gateways;
use App\Models\PaymentPlans;
use App\Models\Setting;
use App\Models\HowitWorks;
use App\Models\User;
use App\Models\UserAffiliate;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Subscription;


/**
 * Controls ALL Payment Gateway actions
 */
class GatewayController extends Controller
{

    function gatewayCodesArray(){
        return array(
            "stripe",
            "paypal",
        );
    }

    function defaultGatewayDefinitions(){
        $gateways = [
            [
                "code" => "stripe",
                "title" => "Stripe",
                "link" => "https://stripe.com/",
                "active" => 0,                      //if user activated this gateway - dynamically filled in main page
                "available" => 1,                   //if gateway is available to use
                "img" => "/assets/img/payments/stripe.svg",
                "whiteLogo" => 0,                   //if gateway logo is white
                "mode" => 0,                        // Option in settings - Automatically set according to the "Development" mode. "Development" ? sandbox : live (PAYPAL - 1)
                "sandbox_client_id" => 1,           // Option in settings 0-Hidden 1-Visible
                "sandbox_client_secret" => 1,       // Option in settings
                "sandbox_app_id" => 0,              // Option in settings
                "live_client_id" => 1,              // Option in settings
                "live_client_secret" => 1,          // Option in settings
                "live_app_id" => 0,                 // Option in settings
                "currency" => 1,                    // Option in settings
                "currency_locale" => 0,             // Option in settings
                "base_url" => 1,                    // Option in settings
                "sandbox_url" => 0,                 // Option in settings
                "locale" => 0,                      // Option in settings
                "validate_ssl" => 0,                // Option in settings
                "logger" => 0,                      // Option in settings
                "notify_url" => 0,                  // Gateway notification url at our side
                "webhook_secret" => 0,              // Option in settings
            ],
            [
                "code" => "paypal",
                "title" => "PayPal",
                "link" => "https://www.paypal.com/",
                "active" => 0,
                "available" => 1,
                "img" => "/assets/img/payments/paypal.svg",
                "whiteLogo" => 0,
                "mode" => 1,
                "sandbox_client_id" => 1,
                "sandbox_client_secret" => 1,
                "sandbox_app_id" => 0,
                "live_client_id" => 1,
                "live_client_secret" => 1,
                "live_app_id" => 1,
                "currency" => 1,
                "currency_locale" => 1,
                "notify_url" => 0,
                "base_url" => 0,
                "sandbox_url" => 0,
                "locale" => 0,
                "validate_ssl" => 0,
                "webhook_secret" => 0,
                "logger" => 0,
            ],
        ];

        return $gateways;
    }

    function readManageGatewaysPageData(){

        $defaultGateways = self::defaultGatewayDefinitions();
        $requiredGatewayData = [];

        $gatewayActiveData = [];
        $gatewaysData = Gateways::all();
        foreach($gatewaysData as $gw){
            array_push($gatewayActiveData, array(
                "code" => $gw->code,
                "is_active" => $gw->is_active
            ));
        }

        foreach ($defaultGateways as $gateway) {
            $code = $gateway['code'];
            $is_active = 0;
            foreach($gatewaysData as $gwdata){
                if($gwdata['code'] == $code){
                    $is_active = $gwdata['is_active'];
                    break;
                }
            }
            array_push($requiredGatewayData, array(
                "code" => $code,
                "title" => $gateway['title'],
                "link" => $gateway['link'],
                "available" => $gateway['available'],
                "img" => $gateway['img'],
                "whiteLogo" => $gateway['whiteLogo'],
                "active" => $is_active ?? 0,
            ));
        }

        return $requiredGatewayData;
    }



    /**
     * Index page of Payment Gateways in Admin Panel
     */
    public function paymentGateways(){

        $gateways = self::readManageGatewaysPageData();

        return view('panel.admin.finance.gateways.index', compact('gateways'));
    }



    function getCurrencyOptions($index){
        $returnText="";
        $currencies = Currency::all();
        foreach ($currencies as $currency) {
            $cindex = $currency->id;
            $country = self::appendNBSPtoString($currency->country, 41);
            $code = self::appendNBSPtoString($currency->code, 5);
            $text = $country.$code.$currency->symbol;
            $selected = (int)$index == (int)$cindex ? 'selected' : '';
            $returnText = $returnText.'<option value="'.$cindex.'" '.$selected.' style=\'font-family: "Courier New", Courier, monospace;\' >'.$text.'</option>';
        }
        return $returnText;
    }

    /**
     * Fills given string with &nbsp; at the end.
     *
     * Used in Country select tag.
     */
    public function appendNBSPtoString($stringForAppend, $charCount){

        $length = Str::length($stringForAppend);
        $remainingCharcount = $charCount - $length;

        if($remainingCharcount<1){
            return $stringForAppend;
        }else{
            $newString = $stringForAppend;
            for($i=1; $i <= $remainingCharcount; $i++){
                $newString = $newString.'&nbsp;';
            }
            return $newString;
        }

    }


    /**
     * Settings page of gateways in Admin Panel
     */
    public function gatewaySettings($code){

        if(!in_array($code, self::gatewayCodesArray())){abort(404);}

        $settings = Gateways::where("code", $code)->first();
        if($settings != null){
        }else{
            $settings = new Gateways();
            $settings->code = $code;
            $settings->is_active = 0;
            $settings->currency = "124"; //Default currency for Stripe - USD
            $settings->save();
        }

        $currencies = self::getCurrencyOptions($settings->currency);

        $gateways = self::defaultGatewayDefinitions();

        $options = $gateways[0];

        foreach($gateways as $gateway){
            if($gateway['code'] == $code){
                $options = $gateway;
                break;
            }
        }


        return view('panel.admin.finance.gateways.settings', compact('settings', 'currencies', 'options'));
    }

    /**
     * Save settings of gateway in Admin Panel
     */
    public function gatewaySettingsSave(Request $request){

        if($request->code != null){
            if(!in_array($request->code, self::gatewayCodesArray())){abort(404);}
        }else{
            abort(404);
        }

        $settings = Gateways::where("code", $request->code)->first();
        if($settings != null){

            if($request->is_active == "on"){
                $settings->is_active = 1;
            }else{
                $settings->is_active = 0;
            }

            $settings->title = $request->title;
            $settings->currency = $request->currency;
            $settings->currency_locale = $request->currency_locale;
            $settings->live_client_id = $request->live_client_id;
            $settings->live_client_secret = $request->live_client_secret;
            $settings->live_app_id = $request->live_app_id;
            $settings->sandbox_client_id = $request->sandbox_client_id;
            $settings->sandbox_client_secret = $request->sandbox_client_secret;
            $settings->sandbox_app_id = $request->sandbox_app_id;
            $settings->base_url = $request->base_url;
            $settings->sandbox_url = $request->sandbox_url;
            $settings->mode = $request->mode;

            $settings->save();

            if($settings->is_active == 1){
                // Update all product ids' and create new price ids'
                $code = $request->code;

                try{
                    if($code == 'stripe'){
                        $temp = StripeController::saveAllProducts();
                    }
                    if($code == 'paypal'){
                        $temp = PaypalController::saveAllProducts();
                    }

                }catch(\Exception $ex){
                    error_log("GatewayController::gatewaySettingsSave()\n".$ex->getMessage());
                    return back()->with(['message' => $ex->getMessage(), 'type' => 'error']);
                }
                return back()->with(['message' => __('Product ID and Price ID of all membership plans are generated.'), 'type' => 'success']);
            }

        }else{
            $settings = new Gateways();
            $settings->code = $request->code;
            $settings->is_active = 0;
            $settings->currency = "124"; //Default currency for Stripe - USD
            $settings->save();
        }

    }


    public function gatewayData($code){
        $gateways = self::defaultGatewayDefinitions();
        $options = $gateways[0];
        foreach($gateways as $gateway){
            if($gateway['code'] == $code){
                $options = $gateway;
                break;
            }
        }
        return $options;
    }













}
