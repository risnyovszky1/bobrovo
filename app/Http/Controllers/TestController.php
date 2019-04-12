<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TestController extends Controller
{
  public function __construct(){
    $this->middleware('guest:bobor');
  }

  // LOGIN STUDENTS - APP
  public function getLoginStudentPage(){
    return view('general.login_student');
  }

  public function postLoginStudentPage(Request $request){
    $code = $request->input('code');
    $sid = DB::table('students')->select('id', 'code')->where('code', $code)->first();
    
    
    if ($sid){
      if (Auth::guard('bobor')->loginUsingId($sid->id)){
        return redirect()->route('student_home');
      }
      //return view('general.login_student', ['success' => 'lgging in failed']); 
    }
    else{
      die("student with code not found: " . $code);
    }

    return view('general.login_student', ['success' => 'No id found']);    
  }



  public function getLogoutStudent(){
    Auth::guard('bobor')->logout();
    return redirect()->route('login_student');
  }

  public function getStudentHomePage(){
    return view('student.home');
  }

  public function getStudentTestsPage(){
    $groups = DB::table('student_group')
        ->join('groups', 'student_group.group_id', 'groups.id')
        ->select('groups.id', 'groups.name', 'groups.description')
        ->where('student_group.student_id', Auth::user()->id)
        ->orderBy('groups.name', 'ASC')
        ->get();

    $tests = array();
    // to do 
    $states = array();

    foreach($groups as $group){
      $tests[$group->id] = DB::table('tests')
        ->select('id', 'name', 'available_from', 'available_to')
        ->where([
          ['group_id', $group->id],
          ['public', true]
          ])
        ->orderBy('name', 'ASC')
        ->get();
    }
    
    return view('student.tests', ['groups' => $groups, 'tests' => $tests]);
  }

  public function getTestPage($id){
    $test = DB::table('tests')
      ->where('id', $id)
      ->first();
    
    $state = DB::table('test_student_state')
      ->where([
        ['test_id', $id],
        ['student_id', Auth::user()->id]
      ])
      ->first();
  
    $settings = DB::table('tests')
      ->select('id', 'name', 'available_description', 'mix_questions', 'available_answers')
      ->where('id', $id)
      ->first();
    $questions = DB::table('question_test')
      ->join('questions', 'question_test.question_id', 'questions.id')
      ->select('questions.id', 'title', 'question', 'answer', 'a', 'b', 'c', 'd', 'description', 'type')
      ->where('test_id', $id)
      ->get();  

    Session::put('testSettings', $settings);
    Session::put('testQuestions', $settings->mix_questions == 0 ? $questions : $questions->shuffle());
    
    return view('student.test_one', ['test' => $test, 'state' => $state]);
  }

  public function getSolvingPage($id){
    $state = DB::table('test_student_state')
      ->where([
        ['test_id', $id],
        ['student_id', Auth::user()->id]
      ])
      ->first();
    
      if (!$state){
        DB::table('test_student_state')
          ->insert([
            'state' => 2,
            'student_id' => Auth::user()->id,
            'test_id' => $id
            ]);
        
        $state = DB::table('test_student_state')
          ->where([
            ['test_id', $id],
            ['student_id', Auth::user()->id]
          ])
          ->first();
      }
      else if ($state->state != 3){
        DB::table('test_student_state')
          ->where([
            ['test_id', $id],
            ['student_id', Auth::user()->id]
          ])
          ->update([
            'state' => 1
          ]);
      }

    return view('student.solve', ['questions' => Session::get('testQuestions'), 'state' => $state]);
  }

  public function getQuestionPage($id, $ord){
    $question = Session::get('testQuestions')->get($ord - 1);

    $ans = DB::table('answers')
      ->where([
        ['test_id', $id],
        ['student_id', Auth::user()->id],
        ['question_id', Session::get('testQuestions')->get($ord - 1)->id]
      ])->first();


    return view('student.question', ['question' => $question, 'curr'=> $ord, 'answer' => $ans]);
  }

  public function postQuestionPage(Request $request, $id, $ord){
    $qid = $request->input('question-id');

    $this->validate($request, [
      'answer-' . $qid => 'required'
    ]);

    $ans = $request->input('answer-' . $qid);

    $was = DB::table('answers')
      ->where([
        ['test_id', $id],
        ['student_id', Auth::user()->id],
        ['question_id', Session::get('testQuestions')->get($ord - 1)->id]
      ])->first();

    if ($was){
      DB::table('answers')
          ->where([
            ['test_id', $id],
            ['student_id', Auth::user()->id],
            ['question_id', Session::get('testQuestions')->get($ord - 1)->id]
          ])
          ->update(['answer' => $ans]);
      }
    else{
      DB::table('answers')
        ->insert([
          'answer' => $ans,
          'test_id' => $id,
          'student_id' => Auth::user()->id,
          'question_id' => Session::get('testQuestions')->get($ord - 1)->id,
        ]);
    }

    if ($ord >= count(Session::get('testQuestions'))){
      return redirect()->route('finish_student', ['id' => $id]);
    }

    return redirect()->route('question_student', ['id' => $id, 'ord' => $ord + 1]);
  }

  public function getFinishPage($id){
    return view('student.finish', ['qid' => $id]);
  }

  public function postFinishPage($id){
    $was = DB::table('test_student_state')
      ->where([
        ['student_id', Auth::user()->id],
        ['test_id', $id]
      ])
      ->first();

    if ($was){
      DB::table('test_student_state')
        ->where([
          ['student_id', Auth::user()->id],
          ['test_id', $id]
        ])
        ->update(['state' => 3]);
    }
    else{
      DB::table('test_student_state')
        ->insert([
          'state' => 3,
          'student_id' => Auth::user()->id,
          'test_id' => $id
          ]);
    }

    return redirect()->route('testone_student', ['id' => $id]);
  }

  public function getResultsPage($id){
    $studentAns = DB::table('answers')
      ->where([
        ['test_id', $id],
        ['student_id', Auth::user()->id]
      ])->get();

    $ans = array();
    foreach($studentAns as $a){
      $ans[$a->question_id] = $a->answer; 
    }
    
    $realAns = DB::table('question_test')
      ->join('questions', 'question_test.question_id', 'questions.id')
      ->select('questions.id', 'title', 'question', 'a', 'b', 'c', 'd', 'answer')
      ->where('test_id', $id)
      ->get();

    $stats = null;
    if (Session::get('testSettings')->available_answers){
      $count = 0;
      foreach($realAns as $a){
        if (!empty($ans[$a->id]) && $ans[$a->id] == $a->answer)
          $count++;
      }
      $stats = array(
        'total' => count($realAns),
        'answered' => count($ans),
        'good' => $count
      );
    }

    return view('student.results', ['answers' => $ans, 'questions' => $realAns, 'stats' => $stats]);
  }

  public function getMeasereQuestionTime(Request $request){
    $time = DB::table('measurements')
      ->where([
        ['student_id', Auth::user()->id],
        ['question_id', $request->input('question_id')],
        ['test_id', $request->input('test_id')]
      ])->value('time_spent');

    if ($time){
      DB::table('measurements')
        ->where([
          ['student_id', Auth::user()->id],
          ['question_id', $request->input('question_id')],
          ['test_id', $request->input('test_id')]
        ])
        ->update([
          'time_spent' => $time + floatval($request->input('time'))
        ]);
    }
    else{
      DB::table('measurements')->insert([
        'test_id' => $request->input('test_id'),
        'question_id' => $request->input('question_id'),
        'student_id' => Auth::user()->id,
        'time_spent' => $request->input('time')
      ]);
    }
    return response('Hello Word!', 200);
  }
}
