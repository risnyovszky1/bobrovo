<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Faq;

class FaqController extends Controller
{
    //
    public function index()
    {
        $faqFeed = Faq::query()->orderBy('question', 'asc')->get();
        return view('admin.faq.list', ['faq' => $faqFeed]);
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'question' => 'required|min:6',
            'answer' => 'required',
        ]);

        $faq = new Faq([
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
        ]);

        $faq->save();

        $this->flashMsg('Úspešne ste odpovedali FAQ otázku.');

        return redirect()->route('faq.edit', $faq);
    }

    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', ['faq' => $faq]);
    }

    public function update(Request $request, Faq $faq)
    {
        $question = $request->input('question');
        $answer = $request->input('answer');

        $faq->update([
            'answer' => $answer,
            'question' => $question,
        ]);

        return redirect()->route('faq.edit', $faq);
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('faq.index');
    }
}
