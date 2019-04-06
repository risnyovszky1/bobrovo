<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Test;
use Auth;

class TestManageController extends Controller
{
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
}
