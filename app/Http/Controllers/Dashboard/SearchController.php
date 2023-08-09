<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\OpenAIGenerator;
use App\Models\OpenaiGeneratorChatCategory;
use App\Models\UserOpenai;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $word = $request->search;
        $result = '';

        if ($word == 'delete'){
            $template_search = [];
            $workbook_search = [];
            $ai_chat_search = [];
        }else {
            $template_search = OpenAIGenerator::where('title', 'like', "%$word%")->get();

            $workbook_search = UserOpenai::where('title', 'like', "%$word%")->get();

            $ai_chat_search = OpenaiGeneratorChatCategory::where('name', 'like', "%$word%")->orWhere('description', 'like', "%$word%")->get();

            if (count($template_search)==0 and count($workbook_search)==0 and count($ai_chat_search)==0){
                $result = 'null';
            }
        }
        $html = view('panel.layout.components.search_results', compact('template_search', 'workbook_search', 'ai_chat_search', 'result'))->render();
        return response()->json(compact('html'));
    }
}
