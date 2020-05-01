<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;
use App\FAQ;
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
