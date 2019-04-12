<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\News;
use App\FAQ;
use Auth;
use Mail;

class PagesController extends Controller
{
  // ====================================
  // |                                  |
  // |          GENERAL PAGES           |
  // |                                  |
  // ====================================

  public function getHomePage(){
    $newsFeed = DB::table('news')->select('news_id', 'title', 'created_at')->where('visible', 1)->orderBy('created_at', 'desc')->limit(3)->get();
    return view('general.index', ['newsFeed' => $newsFeed]);
  }

  public function postHomePage(Request $request){
    $newsFeed = DB::table('news')->select('news_id', 'title', 'created_at')->where('visible', 1)->orderBy('created_at', 'desc')->limit(3)->get();
    
    $this->validate($request, [
      'name' => 'required',
      'e-mail' => 'email|required',
      'message' => 'required',
      'default-conditions' => 'required'
    ]);

    $data = array(
      'mail' => $request->input('e-mail'),
      'name' => $request->input('name'),
      'phone' => $request->input('telnumber'), 
      'msg' => $request->input('message')
    );
      
    $from_mail = $request->input('e-mail');
    $from_name = $request->input('name');

    Mail::send('emails.mail', $data, function($message) use ($from_mail, $from_name){
      $message->from($from_mail, $from_name);
      $message->to('risnyo96@gmail.com')->subject('Kontakný formulár - Bobrovo');
    });

    return view('general.index', ['newsFeed' => $newsFeed, 'success' => "Email bol odoslaný!"]);
  }

  // REGISTER
  public function getRegisterPage(){
    return view('general.register');
  }

  public function postRegisterPage(Request $request){
    $this->validate($request, [
      'first-name' => 'required',
      'last-name' => 'required',
      'email' => 'email|required|unique:users',
      'password' => 'required|min:6|required_with:password-rpt|same:password-rpt',
      'password-rpt' => 'required|min:6',
      'default-conditions' => 'required',
    ]);


    $newUser = new User([
      'email' => $request->input('email'),
      'first_name' => $request->input('first-name'),
      'last_name' => $request->input('last-name'),
      'password' => bcrypt($request->input('password')),
      'is_admin' => false,
    ]);

    $newUser->save();

    return view('general.register', ['message' => 'Úspešná registrácia!']);
  }

  public function getNewsPage(){
    $newsFeed = DB::table('news')->select('news_id', 'title', 'created_at')->where('visible', 1)->orderBy('created_at', 'desc')->get();
    return view('general.news', ['newsFeed' => $newsFeed]);
  }

  public function getNewsOnePage($id){
    $news = DB::table('news')->select('title', 'content', 'created_at')->where('news_id', $id)->limit(1)->get();
    return view('general.newsone', ['news' => $news->first()]);
  }

  public function getDefaultConditionPage(){
    return view('general.default_cond');
  }

  public function getFAQPage(){
    $faqs = DB::table('faqs')->orderBy('question', 'asc')->get();
    return view('general.faq', ['faqs' => $faqs]);
  }

}
