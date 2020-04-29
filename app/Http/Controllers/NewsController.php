<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $newsFeed = News::query()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.news.list', ['newsFeed' => $newsFeed]);
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:6',
            'content' => 'required',
            'is-visible' => 'required',
        ]);

        $newNews = new News([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'visible' => $request->input('is-visible') == 'yes' ? true : false,
            'created_by' => Auth::user()->id,
        ]);

        $newNews->save();

        $this->flashMsg('Úspešne ste pridali novinku.');

        return redirect()->route('news.edit', $newNews);
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', ['news' => $news]);
    }

    public function update(Request $request, News $news)
    {
        $title = $request->input('title');
        $content = $request->input('content');
        $visible = $request->input('is-visible') == 'yes' ? true : false;
        $haveImg = !empty($request->file("featured_img"));
        $path = "";

        if ($haveImg){
            $oldImg = DB::table('news')->where('id', $news->id)->pluck('featured_img')->first();
            if ($oldImg){
                Storage::disk('public_uploads')->delete(ltrim($oldImg, '/'));
            }

            $path = $request->file('featured_img')->store('img', 'public_uploads');
        }

        $news->update([
            'title' => $title,
            'content' => $content,
            'visible' => $visible,
            'featured_img' => empty($path) ? null : '/' . $path,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->flashMsg('Úspešne ste upravili novinku.');

        return redirect()->route('news.edit', $news);
    }

    public function destroy(News $news)
    {
        $news->delete();

        $this->flashMsg('Úspešne ste vymazali novinku.');

        return redirect()->route('news.index');
    }
}
