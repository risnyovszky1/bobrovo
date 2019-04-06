<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Test;
use App\Question;
use Auth;
use Faker\Factory as Faker;


class BobrovoController extends Controller
{
    // LOGIN ADMIN / TEACHER
    public function getLogut(){
      Auth::logout();
      return redirect()->route('homepage');
    }

    public function getLoginTeacherPage(){
      return view('general.login_teacher');
    }

    public function getBadLinkPage(){
      return view('admin.badlink');
    }

    public function postLoginTeacherPage(Request $request){
      $this->validate($request, [
          'email' => 'email|required',
          'password' => 'required'
        ]
      );

      $userData = array(
        'email' => $request->input('email'),
        'password' => $request->input('password'),
      );

      if (Auth::attempt($userData)){
        return redirect()->route('admin');
      }

      return view('general.login_teacher');;
    }

    // ====================================
    // |                                  |
    // |            ADMIN PAGES           |
    // |                                  |
    // ====================================

    public function getUcitelAdminPage(){
      return view('admin.admin');
    }

    // ---- USERS ----
    public function getAllUsersPage(){
      $users = DB::table('users')
          ->join('students', 'users.id', 'students.teacher_id')
          ->select('users.id', 'users.first_name', 'users.last_name', 'is_admin', 'email', DB::raw('count(students.id) as students_total'))
          ->orderBy('last_name', 'ASC')->orderBy('first_name', 'ASC')
          ->groupBy('teacher_id')
          ->get();
      
      return view('admin.users_all', ['users' => $users]);
    }

    public function getToggleAdminUser($id){
      $val = DB::table('users')->select('is_admin')->where('id', $id)->first()->is_admin;
      
      DB::table('users')
          ->where('id', $id)
          ->update([
            'is_admin' => $val ? 0 : 1
          ]);

      return redirect()->route('users.all');
    }

    public function getDeleteUser($id){
      if ($id != Auth::user()->id){
        DB::table('users')->where('id', $id)->delete();
      }

      return redirect()->route('users.all');
    }


    // ====================================
    // |                                  |
    // |          TEACHER PAGES           |
    // |                                  |
    // ====================================

    

    // ---- QUESTIONS ---- 
    public function getAllQuestionsPage(){
      $questions = DB::table('questions')
          ->select('id', 'title', 'difficulty', 'type')
          ->where('public', true)
          ->orderBy('title', 'ASC')
          ->get();
      $tests = DB::table('tests')
          ->select('id', 'name')
          ->where('teacher_id', Auth::user()->id)
          ->orderBy('name', 'ASC')
          ->get();
      
    
      $tmp = $this->filterQuestions($questions);

      return view('admin.questions_all', [
        'tests' => $tests,
        'questions' => $tmp,
        'title' => 'Všetky otázky'
      ]);
    }

    public function filterQuestions($questions){
      $list = [];
      $filter = Session::get('questionFilter');
      $category = !empty($filter['category']) ? $filter['category'] : null;
      $type = !empty($filter['type']) ? $filter['type'] : null;
      $diffFrom = !empty($filter['difficulty_from']) ? $filter['difficulty_from'] : null;
      $diffTo = !empty($filter['difficulty_to']) ? $filter['difficulty_to'] : null;
      
      $c = 0;

      foreach($questions as $q){
        if ($type){
          if ($type == 'just-interactive' && $q->type != 5) continue;
          if ($type == 'no-interactive' && $q->type == 5) continue;
        }
        
        $qCat = DB::table('question_category')->where('question_id', $q->id)->pluck('category_id');
        if ($category && !$this->haveCategory($qCat, $category)) continue;
        
        if ($diffFrom && $diffTo && ($diffFrom >= $q->difficulty && $diffTo <= $q->difficulty)) continue;

        $rating = DB::table('ratings')->select('rating')->where('question_id', $q->id)->avg('rating');

        
        $list[] = (object) array(
          'id' => $q->id,
          'title' => $q->title,
          'difficulty' => $q->difficulty,
          'type' => $q->type,
          'rating' => round($rating, 1),
          'categories' => $this->categoriesToArray($qCat),
        );
      }
      
      return $list;
    }

    public function haveCategory($qCat, $fCat){
      if ($qCat == null || $fCat == null) return false;

      foreach($qCat as $q){
        foreach($fCat as $f){
          if ($f == $q){
            return true;
          }
        }
      }

      return false;
    }

    public function categoriesToArray($categories){
      if (count($categories) == 0) return [];
      $query = DB::table('categories');
      foreach($categories as $cat){
        $query->orWhere('id', $cat);
      }

      return $query->pluck('name')->toArray();
    }

    public function postAllQuestionsPage(Request $request){
      $this->validate($request, [
        'questions' => 'required',
        'test-select' => 'required'
      ]);

      foreach ($request->input('questions') as $q) {
        $count = DB::table('question_test')
            ->where([
              ['question_id', $q],
              ['test_id', $request->input('test-select')]])
            ->count();

        if ($count == 0){
          DB::table('question_test')->insert([
            'question_id' => $q,
            'test_id' => $request->input('test-select')
          ]);
        }
      }

      return redirect()->route('questions.all');
    }

    public function getMyQuestionsPage(){
      $questions = DB::table('questions')
          ->select('id', 'title', 'difficulty', 'type')
          ->where('created_by', Auth::user()->id)
          ->orderBy('title', 'ASC')
          ->get();
      $tests = DB::table('tests')
          ->select('id', 'name')
          ->where('teacher_id', Auth::user()->id)
          ->orderBy('name', 'ASC')
          ->get();
      
      $tmp = $this->filterQuestions($questions);

      return view('admin.questions_all', [
        'tests' => $tests,
        'questions' => $tmp,
        'title' => 'Moje otázky'
      ]);
    }

    public function postMyQuestionsPage(Request $request){
      $this->validate($request, [
        'questions' => 'required',
        'test-select' => 'required'
      ]);

      foreach ($request->input('questions') as $q) {
        $count = DB::table('question_test')
            ->where([
              ['question_id', $q],
              ['test_id', $request->input('test-select')]])
            ->count();

        if ($count == 0){
          DB::table('question_test')->insert([
            'question_id' => $q,
            'test_id' => $request->input('test-select')
          ]);
        }
      }

      return redirect()->route('questions.my');
    }

    public function getQuestionPage($id){
      $question = DB::table('questions')->where('id', $id)->first();
      $comments = DB::table('comments')
          ->join('users', 'comments.user_id', 'users.id')
          ->select('comment', 'comments.created_at', 'first_name', 'last_name')
          ->where('question_id', $id)
          ->orderBy('created_at', 'DESC')
          ->get();
      $rating = DB::table('ratings')
          ->select('rating')
          ->where('question_id', $id)
          ->avg('rating');

      $tests = DB::table('tests')
          ->select('id', 'name')
          ->where('teacher_id', Auth::user()->id)
          ->orderBy('name', 'ASC')
          ->get();
      
      $myRating = DB::table('ratings')
          ->select('rating')
          ->where([
            ['question_id', $id],
            ['user_id', Auth::user()->id]
            ])
          ->first();
        
      $categories = DB::table('question_category')
          ->join('categories', 'question_category.category_id', 'categories.id')
          ->select('name')
          ->where('question_id', $id)
          ->get();
      
      return view('admin.questions_one', [
        'question' => $question,
        'comments' => $comments,
        'rating' => round($rating, 1),
        'tests' => $tests,
        'myRating' => $myRating,
        'categories' => $categories
      ]);
    }

    public function postQuestionPage(Request $request, $id){
      $this->validate($request, [
        'test' => 'required'
      ]);

      $count = DB::table('question_test')
          ->where([
            ['question_id', $id],
            ['test_id', $request->input('test')],
          ])
          ->count();

      if ($count == 0){
        DB::table('question_test')
            ->insert([
              'question_id' => $id, 
              'test_id' => $request->input('test')
            ]);
      }

      return redirect()->route('questions.one', ['id' => $id]);
    }

    public function getDeleteQuestion($id){
      $question = Question::find($id); 
      $question->delete();
      return redirect()->route('questions.all');
    }

    public function getEditQuestionPage($id){
      $question = Question::find($id);
      $cat = DB::table('question_category')->select('category_id')->where('question_id', $id)->get();
      
      $categories = array();
      foreach ($cat as $c) {
        $categories[] = $c->category_id;
      }

      return view('admin.questions_edit', ['question' => $question, 'categories' => $categories]);
    }

    public function postEditQuestionPage(Request $request, $id){
      $question = Question::find($id);

      $this->validate($request, [
        'title' => 'required',
        'question' => 'required',
        'answer' => 'required',
        'difficulty' => 'required',
       
      ]);

      $question->title = $request->input('title');
      $question->question = $request->input('question');
      
      $question->answer = $request->input('answer');
      $question->difficulty = $request->input('difficulty');
      $question->description = $request->input('description') ? $request->input('description') : ' ';
      $question->description_teacher = $request->input('description_teacher') ? $request->input('description_teacher') : ' ';
      $question->public = $request->input('public') != null ? true : false;

      if ($question->type <= 3){
        $this->validate($request, [
          'answer-a' => 'required',
          'answer-b' => 'required',
          'answer-c' => 'required',
          'answer-d' => 'required',
        ]);

        $question->a = $request->input('answer-a');
        $question->b = $request->input('answer-b');
        $question->c = $request->input('answer-c');
        $question->d = $request->input('answer-d');
      }
      else if ($question->type == 4){
        if ($request->file('answer-a-img') != null){
          Storage::disk('public_uploads')->delete(ltrim($question->a,  '/'));
          $path = $request->file('answer-a-img')->storeAs('img/answers', $question->id . 'a' . '.' . $request->file('answer-a-img')->getClientOriginalExtension(), 'public_uploads');
          $question->a = '/' . $path;
        }
        if ($request->file('answer-b-img') != null){
          Storage::disk('public_uploads')->delete(ltrim($question->b,  '/'));
          $path = $request->file('answer-b-img')->storeAs('img/answers', $question->id . 'b' . '.' . $request->file('answer-b-img')->getClientOriginalExtension(), 'public_uploads');
          $question->b = '/' . $path;
        }
        if ($request->file('answer-c-img') != null){
          Storage::disk('public_uploads')->delete(ltrim($question->c,  '/'));
          $path = $request->file('answer-c-img')->storeAs('img/answers', $question->id . 'c' . '.' . $request->file('answer-c-img')->getClientOriginalExtension(), 'public_uploads');
          $question->c = '/' . $path;
        }
        if ($request->file('answer-d-img') != null){
          Storage::disk('public_uploads')->delete(ltrim($question->d,  '/'));
          $path = $request->file('answer-d-img')->storeAs('img/answers', $question->id . 'd' . '.' . $request->file('answer-d-img')->getClientOriginalExtension(), 'public_uploads');
          $question->d = '/' . $path;
        }
      }
      
      $question->save();

      DB::table('question_category')->where('question_id', $id)->delete();
      if ($request->input('category')){
        foreach ($request->input('category') as $cat) {
          DB::table('question_category')->insert([
            'question_id' => $id,
            'category_id' => $cat
          ]);
        }
      }

      return redirect()->route('questions.one', ['id' => $id]);
    }

    public function getQuestionRating($id, $rating){
      $count = DB::table('ratings')
          ->where([
            ['question_id', $id],
            ['user_id', Auth::user()->id]
          ])
          ->count();

      if ($count == 0){
        DB::table('ratings')->insert([
          'question_id' => $id,
          'user_id' => Auth::user()->id,
          'rating' => $rating
        ]);
      }
      else{
        DB::table('ratings')
          ->where([
            ['question_id', $id],
            ['user_id', Auth::user()->id]
          ])
          ->update([
          'rating' => $rating,
        ]);
      }

      return redirect()->route('questions.one', ['id' => $id]);
    }

    public function getAddQuestionPage(){

      return view('admin.questions_add');
    }

    public function postAddQuestionPage(Request $request){
      $this->validate($request, [
        'title' => 'required',
        'question' => 'required',
        'answer' => 'required',
        'type' => 'required',
        'difficulty' => 'required',
      ]);

      $type = intval($request->input('type'));
  
      if ($type >= 1 && $type <= 3){
        // if type is text: in rows, in cols, 2x2
        $this->validate($request, [
          'answer-a' => 'required',
          'answer-b' => 'required',
          'answer-c' => 'required',
          'answer-d' => 'required',
        ]);

        $q = new Question([
          'title' => $request->input('title'),
          'question' => $request->input('question'),
          'a' => $request->input('answer-a'),
          'b' => $request->input('answer-b'),
          'c' => $request->input('answer-c'),
          'd' => $request->input('answer-d'),
          'answer' => $request->input('answer'),
          'type' => $type,
          'difficulty' => $request->input('difficulty'),
          'description' => $request->input('description') ? $request->input('description') : '',
          'description_teacher' => $request->input('description_teacher') ? $request->input('description_teacher') : '', 
          'public' => $request->input('public') != null ? true : false,
          'created_by' => Auth::user()->id
        ]);

        $q->save();
      }
      else if ($type == 4){
        // if type is img
        $this->validate($request, [
          'answer-a-img' => 'required',
          'answer-b-img' => 'required',
          'answer-c-img' => 'required',
          'answer-d-img' => 'required',
        ]);

        $q = new Question([
          'title' => $request->input('title'),
          'question' => $request->input('question'),
          'answer' => $request->input('answer'),
          'type' => $type,
          'difficulty' => $request->input('difficulty'),
          'description' => $request->input('description') ? $request->input('description') : '',
          'description_teacher' => $request->input('description_teacher') ? $request->input('description_teacher') : '', 
          'public' => $request->input('public') != null ? true : false,
          'created_by' => Auth::user()->id,
          'a' => 'a',
          'b' => 'a',
          'c' => 'a',
          'd' => 'a',
        ]);

        $q->save();

        $path1 = $request->file('answer-a-img')->storeAs('img/answers', $q->id . 'a' . '.' .$request->file('answer-a-img')->getClientOriginalExtension(), 'public_uploads');
        $path2 = $request->file('answer-b-img')->storeAs('img/answers', $q->id . 'b' . '.' .$request->file('answer-a-img')->getClientOriginalExtension(), 'public_uploads');
        $path3 = $request->file('answer-c-img')->storeAs('img/answers', $q->id . 'c' . '.' .$request->file('answer-a-img')->getClientOriginalExtension(), 'public_uploads');
        $path4 = $request->file('answer-d-img')->storeAs('img/answers', $q->id . 'd' . '.' .$request->file('answer-a-img')->getClientOriginalExtension(), 'public_uploads');

        $q->a = '/' . $path1;
        $q->b = '/' . $path2;
        $q->c = '/' . $path3;
        $q->d = '/' . $path4;
        
        $q->save();
      }
      else{
        // if type is interactive  
      }

      if ($request->input('category')){
        foreach ($request->input('category') as $cat) {
          DB::table('question_category')->insert([
            'question_id' => $q->id,
            'category_id' => $cat
          ]);
        }
      }

      return redirect()->route('questions.one', ['id' => $q->id]);
    }

    public function getFilterPage(){
      return view('admin.questions_filter');
    }

    public function postFilterPage(Request $request){
      $filter = array(
        'category' => $request->input('category'),
        'difficulty_from' => $request->input('difficulty_from'),
        'difficulty_to' => $request->input('difficulty_to'),
        'type' => $request->input('type')
      );

      Session::put('questionFilter', $filter);

      return redirect()->route('questions.all');
    }

    public function getFilterReset(){
      Session::put('questionFilter', null);
      return redirect()->route('questions.all');
    }
}
