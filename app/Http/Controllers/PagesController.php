<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\News;
use App\FAQ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{
    // ====================================
    // |                                  |
    // |          GENERAL PAGES           |
    // |                                  |
    // ====================================

    public function index()
    {
        $newsFeed = News::query()->where('visible', true)->orderBy('created_at', 'desc')->limit(3)->get();
        return view('general.index', ['newsFeed' => $newsFeed]);
    }

    public function sendContactForm(Request $request)
    {
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

        Mail::send('emails.mail', $data, function ($message) use ($from_mail, $from_name) {
            $message->from($from_mail, $from_name);
            $message->to('risnyo96@gmail.com')->subject('Kontakný formulár - Bobrovo');
        });

        return redirect()->route('index')->with(['success' => "Email bol odoslaný!"]);
    }

    // REGISTER
    public function register()
    {
        return view('general.register');
    }

    public function sendRegistration(Request $request)
    {
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

        return redirect()->route('register')->with(['message' => 'Úspešná registrácia!']);
    }

    public function news()
    {
        $newsFeed = News::query()->where('visible', true)->orderBy('created_at', 'desc')->get();
        return view('general.news', ['newsFeed' => $newsFeed]);
    }

    public function showNews(News $news)
    {
        return view('general.newsone', ['news' => $news]);
    }

    public function defaultConditions()
    {
        return view('general.default_cond');
    }

    public function faq()
    {
        $faqs = FAQ::query()->orderBy('question', 'asc')->get();
        return view('general.faq', ['faqs' => $faqs]);
    }

}
