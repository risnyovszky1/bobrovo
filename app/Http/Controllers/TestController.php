<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

      return view('general.login_student', ['success' => 'lgging in failed']); 
    }

    return view('general.login_student', ['success' => 'No id found']);    
  }



  public function getLogoutStudent(){
    Auth::guard('bobor')->logout();
    return redirect()->route('login_student');
  }

  public function getStudentHomePage(){
    $groups = DB::table('student_group')
        ->join('groups', 'student_group.group_id', 'groups.id')
        ->select('groups.id', 'groups.name', 'groups.description')
        ->where('student_group.student_id', Auth::user()->id)
        ->get();

    $tests = array();

    foreach($groups as $group){
      $tests[$group->id] = DB::table('tests')
                            ->select('id', 'name', 'description')
                            ->where('group_id', $group->id)
                            ->get();
    }
    
    return view('student.master', ['groups' => $groups, 'tests' => $tests]);
  }
}
