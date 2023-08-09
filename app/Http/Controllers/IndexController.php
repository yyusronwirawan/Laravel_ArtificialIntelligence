<?php

namespace App\Http\Controllers;

use App\Jobs\SendConfirmationEmail;
use App\Models\Clients;
use App\Models\CustomSettings;
use App\Models\Faq;
use App\Models\FrontendForWho;
use App\Models\FrontendFuture;
use App\Models\FrontendGenerators;
use App\Models\FrontendTools;
use App\Models\Hero;
use App\Models\HowitWorks;
use App\Models\OpenAIGenerator;
use App\Models\OpenaiGeneratorFilter;
use App\Models\PaymentPlans;
use App\Models\Setting;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;



class IndexController extends Controller
{
    public function index(){

        $filters = OpenaiGeneratorFilter::all();
        $templates = OpenAIGenerator::all();
        $plansSubscription = PaymentPlans::where('type', 'subscription')->get();
        $plansPrepaid = PaymentPlans::where('type', 'prepaid')->get();
        $faq = Faq::all();
        $tools = FrontendTools::all();
        $futures = FrontendFuture::all();
        $testimonials = Testimonials::all();
        $howitWorks = HowitWorks::orderBy('order', 'ASC')->limit(3)->get();
        $howitWorksDefaults = self::howitWorksDefaults();
        $clients = Clients::all();
        $who_is_for = FrontendForWho::all();
        $generatorsList = FrontendGenerators::all();



        $setting = Setting::first();
        if ($setting->frontend_additional_url != null){
            return Redirect::to($setting->frontend_additional_url);
        }


        return view('index', compact(
            'templates',
            'plansPrepaid',
            'plansSubscription',
            'filters',
            'faq',
            'tools',
            'testimonials',
            'howitWorks',
            'howitWorksDefaults',
            'clients',
            'futures',
            'who_is_for',
            'generatorsList'
        ));
    }

    public function activate(Request $request){
        $valid = $request->liquid_license_status;
        if ($valid == 'valid'){
            $settings = Setting::first();
            $settings->stripe_status_for_now = 'active';
            $settings->save();
            return redirect()->route('dashboard.index');
        }else{
            echo 'Activation failed!';
        }
    }


    public function howitWorksDefaults(){
        $values = json_decode('{"option": TRUE, "html": ""}');
        $default_html = 'Want to see? <a class="text-[#FCA7FF]" href="https://codecanyon.net/item/magicai-openai-content-text-image-chat-code-generator-as-saas/45408109" target="_blank">'.__('Join').' Magic</a>';

        //Check display bottom line
        $bottomline = CustomSettings::where('key', 'howitworks_bottomline')->first();
        if($bottomline != null){
            $values["option"] = $bottomline->value_int ?? 1;
            $values["html"] = $bottomline->value_html ?? $default_html;
        }else{
            $bottomline = new CustomSettings();
            $bottomline->key = 'howitworks_bottomline';
            $bottomline->title = 'Used in How it Works section bottom line. Controls visibility and HTML value of line.';
            $bottomline->value_int = 1;
            $bottomline->value_html = $default_html;
            $bottomline->save();
            $values["option"] = 1;
            $values["html"] = $default_html;
        }

        return $values;
    }


}
