<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        $this->flashMsg('Úspešne ste pridali FAQ otázku "'. $faq->question . '".');

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

        $this->flashMsg('Úspešne ste upravili FAQ otázku "'. $faq->question . '".');

        return redirect()->route('faq.edit', $faq);
    }

    public function destroy(Faq $faq)
    {
        $this->flashMsg('Úspešne ste vymazali FAQ otázku "'. $faq->question . '".');

        $faq->delete();
        return redirect()->route('faq.index');
    }
}
