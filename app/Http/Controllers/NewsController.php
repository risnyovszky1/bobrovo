<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\News;
use Illuminate\Http\Request;
use Auth;

class NewsController extends Controller
{
    // NEWS 

    public function getAllNewsPage(){
        $newsFeed = DB::table('news')
                ->join('users', 'users.id', 'news.created_by')
                ->select('users.first_name', 'users.last_name', 'news.id as news_id', 'news.title', 'news.created_at')
                ->get();
        return view('admin.news_all', ['newsFeed' => $newsFeed]);
      }
  
      public function getAddNewsPage(){
        return view('admin.news_add');
      }
  
      public function postAddNewsPage(Request $request){
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
        return view('admin.news_add', ['success' => 'Úspešne ste pridali novinku do a feedu.']);
      }
  
      public function getEditNewsPage($news_id){
        $news = DB::table('news')->where('id', $news_id)->limit(1)->get();
        return view('admin.news_edit', ['news' => $news->first()]);
      }
  
      public function postEditNewsPage(Request $request, $news_id){
        $id = $request->input('news-id');
        $title = $request->input('title');
        $content = $request->input('content');
        $visible = $request->input('is-visible') == 'yes' ? true : false;
  
        DB::table('news')->where('id', $id)->update([
          'title' => $title,
          'content' => $content,
          'visible' => $visible,
          'updated_at' => date('Y-m-d H:i:s')
        ]);
  
        $news = DB::table('news')->where('id', $news_id)->limit(1)->get();
        return view('admin.news_edit', ['news' => $news->first()]);
      }
  
      public function getDeleteNews($news_id){
        if (Auth::user()->is_admin != 1)
          return redirect()->route('badlink');
  
        DB::table('news')->where('news_id', $news_id)->delete();
        return redirect()->route('news.all');
      }
}
