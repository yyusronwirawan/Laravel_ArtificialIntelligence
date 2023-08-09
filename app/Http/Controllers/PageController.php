<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function pageContent($slug){
        $page = Page::where('slug', $slug)->first();

        // Check page status
        if ( ! $page->status ) {
            abort(404);
        }

        if ($page) {
            return view('page.index', compact('page'));
        } else {
            abort(404);
        }
    }
   
    public function pageList(){
        $list = Page::orderBy('id', 'asc')->get();
        return view('panel.page.list', compact('list'));
    }

    public function pageAddOrUpdate($id = null){
        if ($id == null){
            $page = null;
        }else{
            $page = Page::where('id', $id)->firstOrFail();
        }

        return view('panel.page.form', compact('page'));
    }

    public function pageDelete($id = null){
        $page = Page::where('id', $id)->firstOrFail();
        $page->delete();
        return back()->with(['message' => 'Deleted Successfully', 'type' => 'success']);
    }

    public function pageAddOrUpdateSave(Request $request){

        if ($request->page_id != 'undefined'){
            $page = Page::where('id', $request->page_id)->firstOrFail();
        }else{
            $page = new Page();
        }

        $page->title = $request->title;
        $page->slug = Str::slug($request->slug);
        $page->content = $request->content;
        $page->status = $request->status;
        $page->save();
    }

    public function pagePrivacy(){
        $settings = Setting::first();

        $page = (object)[];
        $page->status = $settings->privacy_enable;
        $page->title = __('Privacy Policy');
        $page->content = $settings->privacy_content;

        // Check page status
        if ( ! $page->status ) {
            abort(404);
        }

        if ($settings) {
            return view('page.index', compact('page'));
        } else {
            abort(404);
        }
    }

    public function pageTerms(){
        $settings = Setting::first();

        $page = (object)[];
        $page->status = $settings->privacy_enable;
        $page->title = __('Terms and Conditions');
        $page->content = $settings->terms_content;

        // Check page status
        if ( ! $page->status ) {
            abort(404);
        }

        if ($settings) {
            return view('page.index', compact('page'));
        } else {
            abort(404);
        }
    }

}
