<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use OpenAI;
use App\Models\OpenAIGenerator;


class TestController extends Controller
{

    public function index(){
        $kalp = 1;
        $ali = 2+1;
        return $this->karabiber($kalp, $ali);
    }

    public function karabiber($kalp, $ali){
        return $kalp + $ali;
    }


    /*
    public function test(){

        //POST TITLE
        $post_type = '';


        $array = [];

        $array[0]['name'] = 'description';
        $array[0]['type'] = 'textarea';
        $array[0]['question'] = 'Describe What Kind of Code You Need';
        $array[0]['select'] = "";

        $array[1]['name'] = 'code_language';
        $array[1]['type'] = 'text';
        $array[1]['question'] = 'Coding Language (Java, PHP etc.)';
        $array[1]['select'] = "";


        $questions = json_encode($array,JSON_UNESCAPED_SLASHES);

        $opai = new OpenAIGenerator();
        $opai->title = 'AI Code Generator';
        $opai->description = "Generate Codes.";
        $opai->slug = 'ai_code_generator';
        $opai->active = 1;
        $opai->questions = $questions;
        $opai->image = 'none';
        $opai->type = 'code';
        $opai->save();

    }
*/
}
