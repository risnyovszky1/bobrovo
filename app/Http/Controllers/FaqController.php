<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Faq;

class FaqController extends Controller
{
    //
    public function getAllFAQPage(){
        $faqFeed = DB::table('faqs')->orderBy('question', 'asc')->get();
        return view('admin.faq_all', ['faq' => $faqFeed]);
      }
      public function getAddFAQPage(){
        return view('admin.faq_add');
      }
      public function postAddFAQPage(Request $request){
        $this->validate($request, [
          'question' => 'required|min:6',
          'answer' => 'required',
        ]);
  
        $newFAQ = new Faq([
          'question' => $request->input('question'),
          'answer' => $request->input('answer'),
        ]);
  
        $newFAQ->save();
        return view('admin.faq_add', ['success', 'Úspešne ste odpovedali FAQ otázku.']);
      }
  
      public function getEditFAQPage($id){
        $faq = DB::table('faqs')->where('id', $id)->limit(1)->get();
        return view('admin.faq_edit', ['faq' => $faq->first()]);
      }
  
      public function postEditFAQPage(Request $request, $id){
        $cid = $request->input('faq-id');
        $question = $request->input('question');
        $answer = $request->input('answer');
  
        DB::table('faqs')->where('id', $cid)->update([
          'answer' => $answer,
          'question' => $question,
          'updated_at' => date('Y-m-d H:i:s')
        ]);
  
        $news = DB::table('faqs')->where('id', $id)->limit(1)->get();
        return view('admin.faq_edit', ['faq' => $news->first()]);
      }
  
      public function getDeleteFAQ($id){
        if (Auth::user()->is_admin != 1)
          return redirect()->route('badlink');
  
        DB::table('faqs')->where('id', $id)->delete();
        return redirect()->route('faq.all');
      }
}
