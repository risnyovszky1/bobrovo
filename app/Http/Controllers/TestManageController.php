<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Test;
use Auth;

class TestManageController extends Controller
{
    // ---- TESTS ----
    public function getAllTestsPage()
    {
        $tests = DB::table('tests')
            ->join('groups', 'groups.id', 'tests.group_id')
            ->select('tests.id', 'tests.name', 'group_id', 'available_from', 'available_to', 'groups.name as group_name', 'public')
            ->where('teacher_id', Auth::user()->id)
            ->orderBy('name', 'ASC')
            ->get();
        return view('admin.tests_all', ['tests' => $tests]);
    }

    public function getTestPage($id)
    {
        $test = DB::table('tests')
            ->join('groups', 'groups.id', 'tests.group_id')
            ->select('tests.id', 'tests.name', 'tests.description', 'tests.available_from', 'tests.group_id',
                'tests.available_to', 'tests.available_description', 'tests.time_to_do', 'tests.available_answers',
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

    public function getTestEditPage($id)
    {
        $test = DB::table('tests')->where('id', $id)->first();
        $groups = DB::table('groups')->where('created_by', Auth::user()->id)->orderBy('name', 'ASC')->get();
        return view('admin.tests_edit', ['test' => $test, 'groups' => $groups]);
    }

    public function postTestEditPage(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'desc' => 'required',
            'group' => 'required',
            'available_from' => 'required',
            'available_to' => 'required',
            'time_to_do' => 'required'
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
                'time_to_do' => $request->input('time_to_do')
            ]);

        return redirect()->route('tests.one', ['id' => $id]);
    }

    public function getAddTestPage()
    {
        $groups = DB::table('groups')->where('created_by', Auth::user()->id)->orderBy('name', 'ASC')->get();
        return view('admin.tests_add', ['groups' => $groups]);
    }

    public function postAddTestPage(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'desc' => 'required',
            'group' => 'required',
            'available_from' => 'required',
            'available_to' => 'required',
            'time_to_do' => 'required'
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
            'teacher_id' => Auth::user()->id,
            'time_to_do' => $request->input('time_to_do')
        ]);
        $test->save();

        return redirect()->route('tests.all');
    }

    public function getDeleteTest($id)
    {
        DB::table('tests')->where('id', $id)->delete();
        return redirect()->route('tests.all');
    }

    public function getDeleteQuestionFromTest($tid, $qid)
    {
        DB::table('question_test')->where([
            ['test_id', $tid],
            ['question_id', $qid]
        ])->delete();
        return redirect()->route('tests.one', ['id' => $tid]);
    }

    public function getResultsOfTestPage($id)
    {
        $test = DB::table('tests')->select('name', 'group_id', 'id')->where('id', $id)->first();

        $studentsQuery = DB::table('student_group')
            ->join('students', 'student_group.student_id', 'students.id')
            ->select('first_name', 'last_name', 'students.id')
            ->where('group_id', $test->group_id)
            ->get();

        $students = $this->getStudentsTestResults($studentsQuery, $id);

        return view('admin.tests_result', ['test' => $test, 'students' => $students]);
    }

    public function getStudentsTestResults($students, $tid)
    {
        $questions = DB::table('question_test')
            ->join('questions', 'question_test.question_id', 'questions.id')
            ->select('questions.id', 'questions.answer')
            ->where('test_id', $tid)->get();

        foreach ($students as $st) {
            $state = DB::table('test_student_state')->where([
                ['student_id', $st->id],
                ['test_id', $tid]
            ])->first();
            $st->state = $state ? $state->state : 1;
            $st->percent = $st->state == 1 ? 0 : $this->getStudentTestPercent($questions, $st->id, $tid);
        }

        return $students;
    }

    public function getStudentTestPercent($questions, $sid, $tid)
    {
        $good = 0;
        foreach ($questions as $q) {
            $answer = DB::table('answers')
                ->select('answer')
                ->where([
                    ['test_id', $tid],
                    ['student_id', $sid],
                    ['question_id', $q->id]
                ])
                ->first();
            if ($answer && $answer->answer == $q->answer) {
                $good++;
            }
        }

        return round($good / count($questions) * 100, 1);
    }

    public function getResultOfStudentForPage($tid, $sid)
    {
        $test = DB::table('tests')->select('name', 'group_id', 'id')->where('id', $tid)->first();
        $student = DB::table('students')->select('first_name', 'last_name', 'id')->where('id', $sid)->first();

        $questions = DB::table('question_test')
            ->join('questions', 'question_test.question_id', 'questions.id')
            ->select('title', 'question', 'answer', 'a', 'b', 'c', 'd', 'id', 'type')
            ->where('test_id', $tid)
            ->get();

        $answerQuery = DB::table('answers')->select('question_id', 'answer')->where([
            ['test_id', $tid],
            ['student_id', $sid]
        ])
            ->get();

        $answers = [];
        foreach ($answerQuery as $ans) {
            $answers[$ans->question_id] = $ans->answer;
        }

        $good = 0;
        foreach ($questions as $q) {
            if (!empty($answers[$q->id])) {
                if ($answers[$q->id] == $q->answer) {
                    $good++;
                }
            }
        }
        $stats = array(
            'total' => count($questions),
            'answered' => count($answers),
            'good' => $good
        );

        return view('admin.tests_result_student', [
            'student' => $student,
            'test' => $test,
            'questions' => $questions,
            'answers' => $answers,
            'stats' => $stats
        ]);
    }
}
