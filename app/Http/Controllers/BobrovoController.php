<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\News;
use App\FAQ;
use App\Group;
use App\Message;
use App\Student;
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

      return view('general.login_teacher');
    }

    // ====================================
    // |                                  |
    // |            ADMIN PAGES           |
    // |                                  |
    // ====================================

    public function getUcitelAdminPage(){
      return view('admin.admin');
    }


    // ---- NEWS ----

    public function getAllNewsPage(){
      $newsFeed = DB::table('news')
              ->join('users', 'users.id', 'news.created_by')
              ->select('users.first_name', 'users.last_name', 'news.news_id', 'news.title', 'news.created_at')
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
      $news = DB::table('news')->where('news_id', $news_id)->limit(1)->get();
      return view('admin.news_edit', ['news' => $news->first()]);
    }

    public function postEditNewsPage(Request $request, $news_id){
      $id = $request->input('news-id');
      $title = $request->input('title');
      $content = $request->input('content');
      $visible = $request->input('is-visible') == 'yes' ? true : false;

      DB::table('news')->where('news_id', $id)->update([
        'title' => $title,
        'content' => $content,
        'visible' => $visible,
        'updated_at' => date('Y-m-d H:i:s')
      ]);

      $news = DB::table('news')->where('news_id', $news_id)->limit(1)->get();
      return view('admin.news_edit', ['news' => $news->first()]);
    }

    public function getDeleteNews($news_id){
      if (Auth::user()->is_admin != 1)
        return redirect()->route('badlink');

      DB::table('news')->where('news_id', $news_id)->delete();
      return redirect()->route('news.all');
    }


    // ---- FAQ ----

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

    // ====================================
    // |                                  |
    // |          TEACHER PAGES           |
    // |                                  |
    // ====================================

    // ---- MESSAGES ---- 

    public function getMessagesPage(){
      $messages = DB::table('messages')
                ->join('users', 'messages.from', 'users.id')
                ->select('messages.id', 'messages.subject', 'messages.created_at', 'users.email', 'users.first_name', 'users.last_name')
                ->where('to', Auth::user()->id)
                ->orderBy('messages.created_at', 'DESC')
                ->get();
      return view('admin.msg_all', ['messages' => $messages]);
    }

    public function getSendMessagePage(){
      $users = DB::table('users')->select('id', 'first_name', 'last_name', 'email')->where('id', '!=', Auth::user()->id)->get();
      return view('admin.msg_send', ['addresses'=> $users]);
    }

    public function postSendMessagePage(Request $request){
      $users = DB::table('users')->select('id', 'first_name', 'last_name', 'email')->where('id', '!=', Auth::user()->id)->get();
      
      $this->validate($request, [
        'addresses' => 'required',
        'subject' => 'required|max:70',
        'content' => 'required',
      ]);

      foreach ($request->input('addresses') as $addr) {
        $msg = new Message([
          'from' => Auth::user()->id,
          'to' => $addr,
          'subject' => $request->input('subject'),
          'content' => $request->input('content'),
        ]);

        $msg->save();
      }

      return view('admin.msg_send', ['addresses'=> $users, 'success' => "Správa bola odoslaná!"]);
    }

    public function getOneMessagePage($id){
      $msg = DB::table('messages')
              ->join('users', 'messages.from', 'users.id')
              ->select('messages.id', 'messages.subject', 'messages.content', 'users.email', 'users.first_name', 'users.last_name')
              ->where('messages.id', $id)
              ->get();
      return view('admin.msg_one', ['msg' => $msg->first()]);
    }
    public function getAnswerPage($id){
      $msg = DB::table('messages')
              ->join('users', 'messages.from', 'users.id')
              ->select('messages.id', 'messages.subject', 'messages.content', 'users.id as uid', 'users.email', 'users.first_name', 'users.last_name')
              ->where('messages.id', $id)
              ->get();
      return view('admin.msg_answer', ['msg' => $msg->first()]);
    }

    public function postAnswerPage(Request $request, $id){
      $msg = DB::table('messages')
              ->join('users', 'messages.from', 'users.id')
              ->select('messages.id', 'messages.subject', 'messages.content', 'users.id as uid', 'users.email', 'users.first_name', 'users.last_name')
              ->where('messages.id', $id)
              ->get();

      $newMsg = new Message([
        'from' => Auth::user()->id,
        'to' => $request->input('address_id'),
        'subject' => $request->input('subject'),
        'content' => $request->input('content'),
      ]);
      $newMsg->save();
      return view('admin.msg_answer', ['msg' => $msg->first(), 'success' => "Odpoveď bola odoslaná!"]);
    }

    public function getDeleteMessagePage($id){
      $msg =  DB::table('messages')->select('to')->where('id', $id)->first();
      if ($msg->to != Auth::user()->id)
        return redirect()->route('badlink');

      DB::table('messages')->where('id', $id)->delete();
      return redirect()->route('msg.all');
    }


    // ---- GROUPS -----

    public function getGroupsPage(){
      $db = DB::table('groups')
        ->select('id', 'name', 'created_at')
        ->where('created_by', Auth::user()->id)
        ->orderBy('name')
        ->get();

      $groups = array();
      foreach ($db as $item) {
        $record = array(
          'id' => $item->id, 
          'name' => $item->name,
          'created_at' => $item->created_at,
          'total_students' => DB::table('student_group')->where('group_id', $item->id)->count()
        );

        $groups[] = $record;
      }
      return view('admin.groups_all', ['groups' => $groups]);
    }

    public function getAddGroupPage(){
      return view('admin.groups_add');
    }

    public function postAddGroupPage(Request $request){
      $this->validate($request,[
        'title' => 'required|min:6',
        'desc' => 'required|min:10'
      ]);

      $group = new Group([
        'name' => $request->input('title'),
        'description' => $request->input('desc'),
        'created_by' => Auth::user()->id
      ]);

      $group->save();

      return view('admin.groups_add', ['success' => 'Skupina bola úspešne pridaná.']);
    }
    
    public function getDeleteGroup($id){
      $group = DB::table('groups')->select('created_by')->where('id', $id)->first();
      if ($group->created_by != Auth::user()->id)
        return redirect()->route('badlink');

      DB::table('groups')->where('id', $id)->delete();
      return redirect()->route('groups.all');
    }

    public function getGroupOnePage($id){
      $group = DB::table('groups')->where('id', $id)->first();
      $students = DB::table('student_group')
        ->join('students', 'students.id', 'student_group.student_id')
        ->select('students.id', 'students.first_name', 'students.last_name')
        ->where('student_group.group_id', $id)
        ->get();


      return view('admin.groups_one', ['group' => $group, 'students' => $students]);
    }

    public function getEditGroupPage($id){
      $group = DB::table('groups')->where('id', $id)->first();
      return view('admin.groups_edit', ['group' => $group]);
    }

    public function postEditGroupPage(Request $request, $id){
      $this->validate($request, [
        'title' => 'required',
        'desc' => 'required'
      ]);

      DB::table('groups')->where('id', $id)->update([
        'name' => $request->input('title'),
        'description' => $request->input('desc'),
        'updated_at' => date('Y-m-d H:i:s')
      ]);


      $group = DB::table('groups')->where('id', $id)->first();
      return view('admin.groups_edit', ['group' => $group, 'success' => 'Úpravy boli uložené!']);
    }

    // ---- STUDENTS ----

    public function getStudentsPage(){
      $students = DB::table('students')
        ->select('id', 'first_name', 'last_name', 'code')
        ->where('teacher_id', Auth::user()->id)
        ->orderBy('last_name', 'ASC')
        ->orderBy('first_name', 'ASC')
        ->get();
      $groups = DB::table('groups')
        ->select('id', 'name')
        ->where('created_by', Auth::user()->id)
        ->orderBy('name')
        ->get();
      return view('admin.students_all', ['students' => $students, 'groups' => $groups]);
    }

    public function postStudentsPage(Request $request){
      $this->validate($request, [
        'group' => 'required',
        'students' => 'required'
      ]);

      foreach($request->input('students') as $student){
        $count = DB::table('student_group')->where([
            ['student_id', $student],
            ['group_id', $request->input('group')] 
          ])->count();
          
        if ($count == 0){
          DB::table('student_group')->insert([
            'student_id' => $student,
            'group_id' => $request->input('group')
          ]);
        }
      }

      return redirect()->route('students.all');
    }
    
    public function getAddStudentPage(){
      $groups = DB::table('groups')
        ->select('id', 'name')
        ->where('created_by', Auth::user()->id)
        ->orderBy('name')
        ->get();
      return view('admin.students_add', ['groups' => $groups]);
    }

    public function postAddStudentPage(Request $request){
      $this->validate($request, [
        'first-name' => 'required|min:3',
        'last-name' => 'required|min:3'
      ]);
      

      $code = '';
      if ($request->input('generate-random-code') != null){
        $faker = Faker::create();
        while(true){
          $code = $faker->bothify('**********');
          
          $count = DB::table('students')->where([
              ['code', $code]
          ])->count();
          
          if ($count == 0){ 
            break; 
          }
        }
        
      }
      else{
        $this->validate($request, [
          'code' => 'min:6|max:15|unique:students'
        ]);
        $code = $request->input('code');
      }
      
      $student = new Student([
        'first_name' => $request->input('first-name'),
        'last_name' => $request->input('last-name'),
        'code' => $code,
        'teacher_id' => Auth::user()->id,
      ]);

      $student->save();

      if ($request->input('groups') != null){
        foreach ($request->input('groups') as $group) {
          DB::table('student_group')->insert([
            'student_id' => $student->id,
            'group_id' => $group
          ]);
        }
      }
      
      
      $groups = DB::table('groups')
        ->select('id', 'name')
        ->where('created_by', Auth::user()->id)
        ->orderBy('name')
        ->get();
      return view('admin.students_add', ['groups' => $groups, 'success' => 'Úspešne ste pridali žiaka!']);
    }

    public function getStudentProfilPage($id){
      $student = DB::table('students')->where('id', $id)->first();
      $groups = DB::table('student_group')
          ->join('groups', 'groups.id', 'student_group.group_id')
          ->select('groups.id', 'groups.name')
          ->where('student_id', $student->id)
          ->get();

      $groupList = DB::table('groups')
        ->select('id', 'name')
        ->where('created_by', Auth::user()->id)
        ->orderBy('name')
        ->get();
      return view('admin.students_profil', ['student' => $student, 'groups' => $groups, 'groupList' => $groupList]);
    }

    public function postAddStudentToGroup(Request $request, $id){
      $this->validate($request, [
        'add-to-group' => 'required'
      ]);

      $count = DB::table('student_group')->where([
          ['student_id', $id],
          ['group_id', $request->input('add-to-group')] 
      ])->count();

      if ($count == 0){
        DB::table('student_group')->insert([
          'student_id' => $id,
          'group_id' => $request->input('add-to-group')
        ]);
      }

      return redirect()->route('students.one', ['id' => $id]);
    }

    public function getStudentDeletePage($id){
      $student = DB::table('students')->select('teacher_id')->where('id', $id)->first();
      if($student->teacher_id != Auth::user()->id)
        return redirect()->route('badlink');
      
      DB::table('students')->where('id', $id)->delete();
      return redirect()->route('students.all');
    }

    public function getDeleteFromGroup($sid, $gid){
      $student = DB::table('students')->select('teacher_id')->where('id', $id)->first();
      $group = DB::table('groups')->select('created_by')->where('id', $id)->first();
      if($group->created_by != Auth::user()->id || $student->teacher_id != Auth::user()->id)
        return redirect()->route('badlink'); 

      DB::table('student_group')->where([
          ['student_id', $sid],
          ['group_id', $gid]])
        ->delete();
      return redirect()->back();
    }

    public function getAddStudentFromFilePage(){
      $groups = DB::table('groups')
            ->select('id', 'name')
            ->where('created_by', Auth::user()->id)
            ->orderBy('name', 'ASC')
            ->get();

      return view('admin.students_file', ['groups' => $groups]);
    }

    public function postAddStudentFromFilePage(Request $request){
      $this->validate($request, [
        'student_file' => 'required'
      ]);
      
      $group_id = $request->input('group');

      $file = File::get($request->file('student_file')->getRealPath());

      $count = 0;
      $tmp = 0;
      foreach(explode("\n", $file) as $line){
        $data = explode(',', $line);
        
        if (count($data) != 3) continue;
        
        $student = new Student([
          'first_name' => $data[0],
          'last_name' => $data[1],
          'code' => $data[2],
          'teacher_id' => Auth::user()->id
        ]);

        $student->save();
        if ($group_id != ''){
          DB::table('student_group')->insert([
            'student_id' => $student->id,
            'group_id' => $group_id
          ]);
        }
        $count++;
      }

      $groups = DB::table('groups')
            ->select('id', 'name')
            ->where('created_by', Auth::user()->id)
            ->orderBy('name', 'ASC')
            ->get();
            
      return view('admin.students_file', [
        'success'=>'Úsprešne ste pridali ' . $count . ' žiakov!', 
        'file' => $tmp, 
        'groups' => $groups
      ]);;
    }

    // ---- TESTS ----
    public function getAllTestsPage(){
      $tests = DB::table('tests')
          ->join('groups', 'groups.id', 'tests.group_id')
          ->select('tests.id', 'tests.name', 'group_id', 'available_from', 'available_to', 'groups.name as group_name', 'public')
          ->where('teacher_id', Auth::user()->id)
          ->orderBy('name', 'ASC')
          ->get();
      return view('admin.tests_all', ['tests' => $tests]);
    }

    public function getTestPage($id){
      $test = DB::table('tests')
          ->join('groups', 'groups.id', 'tests.group_id')
          ->select('tests.id', 'tests.name', 'tests.description', 'tests.available_from', 'tests.group_id', 
                    'tests.available_to', 'tests.available_description', 'tests.available_answers', 
                    'tests.mix_questions', 'tests.public', 'groups.name as group_name')
          ->where('tests.id', $id)->first();

      $questions = DB::table('question_test')
          ->where('question_test.test_id', $id)
          ->join('questions', 'questions.id', 'question_test.question_id')
          ->select('questions.id', 'questions.title')
          ->orderBy('questions.title', 'ASC')
          ->get();
      
      return view('admin.tests_one', ['test' => $test, 'questions' => $questions]);
    }

    public function getTestEditPage($id){
      $test = DB::table('tests')->where('id', $id)->first(); 
      $groups = DB::table('groups')->where('created_by', Auth::user()->id)->orderBy('name', 'ASC')->get();
      return view('admin.tests_edit', ['test' => $test, 'groups' => $groups]);
    }

    public function postTestEditPage(Request $request, $id){
      $this->validate($request, [
        'title' => 'required',
        'desc' => 'required',
        'group' => 'required',
        'available_from' => 'required',
        'available_to' => 'required',
      ]);

      DB::table('tests')
          ->where('id', $id)
          ->update([
              'name' => $request->input('title'),
              'description' => $request->input('desc'),
              'group_id' => $request->input('group'),
              'available_from' => $request->input('available_from'),
              'available_to' => $request->input('available_to'),
              'available_description' => $request->input('available-desc') != null,
              'available_answers' => $request->input('available-ans') != null,
              'mix_questions' => $request->input('mix-questions') != null,
              'public' => $request->input('public') != null,
              'updated_at' => date('Y-m-d H:i:s'),
            ]);
          
      return redirect()->route('tests.one', ['id' => $id]);
    }

    public function getAddTestPage(){
      $groups = DB::table('groups')->where('created_by', Auth::user()->id)->orderBy('name', 'ASC')->get();
      return view('admin.tests_add', ['groups' => $groups]); 
    }

    public function postAddTestPage(Request $request){
      $this->validate($request, [
        'title' => 'required',
        'desc' => 'required',
        'group' => 'required',
        'available_from' => 'required',
        'available_to' => 'required',
      ]);

      $test = new Test([
        'name' => $request->input('title'),
        'description' => $request->input('desc'),
        'group_id' => $request->input('group'),
        'available_from' => $request->input('available_from'),
        'available_to' => $request->input('available_to'),
        'available_description' => $request->input('available-desc') != null,
        'available_answers' => $request->input('available-ans') != null,
        'mix_questions' => $request->input('mix-questions') != null,
        'public' => $request->input('public') != null,
        'teacher_id' => Auth::user()->id
        ]);
      $test->save();
      
      return redirect()->route('tests.all');
    }

    public function getDeleteTest($id){
      DB::table('tests')->where('id', $id)->delete();
      return redirect()->route('tests.all');
    }

    public function getDeleteQuestionFromTest($tid, $qid){
      DB::table('question_test')->where([
        ['test_id', $tid],
        ['question_id', $qid]
        ])->delete();
      return redirect()->route('tests.one', ['id' => $tid]);
    }

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
      $ratingQuery = DB::table('ratings')
          ->select('question_id', DB::raw('avg(rating) as avg'))
          ->groupBy('question_id')
          ->get();

      $ratings = array();

      foreach($ratingQuery as $rating){
        $ratings[$rating->question_id] = round($rating->avg, 1);
      }

      return view('admin.questions_all', [
        'questions' => $questions, 
        'tests' => $tests,
        'ratings' => $ratings
      ]);
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
}
