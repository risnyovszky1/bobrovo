<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\Question;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Test;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class TestManageController extends Controller
{
    // ---- TESTS ----
    public function index()
    {
        $tests = Test::query()
            ->with('group')
            ->where('teacher_id', Auth::user()->id)
            ->orderBy('name', 'ASC')
            ->get();
        return view('admin.test.list', ['tests' => $tests]);
    }

    public function show(Test $test)
    {
        $test->load('group', 'questions');

        return view('admin.test.show', ['test' => $test]);
    }

    public function edit(Test $test)
    {
        $test->load('group');
        $groups = DB::table('groups')->where('created_by', Auth::user()->id)->orderBy('name', 'ASC')->get();
        return view('admin.test.edit', ['test' => $test, 'groups' => $groups]);
    }

    public function update(Request $request, Test $test)
    {
        $this->validate($request, [
            'title' => 'required',
            'desc' => 'required',
            'group' => 'required',
            'available_from' => 'required',
            'available_to' => 'required',
            'time_to_do' => 'required'
        ]);

        $test->update([
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

        $this->flashMsg('Úspešne ste upravili test!');

        return redirect()->route('test.show', $test);
    }

    public function create()
    {
        $groups = Group::query()->where('created_by', Auth::user()->id)->orderBy('name', 'ASC')->get();
        return view('admin.test.create', ['groups' => $groups]);
    }

    public function store(Request $request)
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

        $this->flashMsg('Úspešne ste pridali test!');

        return redirect()->route('test.index');
    }

    public function destroy(Test $test)
    {
        $test->delete();

        $this->flashMsg('Úspešne ste vymazali test!');

        return redirect()->route('test.index');
    }

    public function removeQuestion(Test $test, Question $question)
    {
        $test->questions()->detach($question->id);

        $this->flashMsg('Úspešne ste odobrali otázku z testu!');

        return redirect()->route('test.show', $test);
    }

    public function result(Test $test)
    {
        $test->load('group');

        $studentsQuery = DB::table('student_group')
            ->join('students', 'student_group.student_id', 'students.id')
            ->select('first_name', 'last_name', 'students.id')
            ->where('group_id', $test->group->id)
            ->get();

        $students = $this->getStudentsTestResults($studentsQuery, $test->id);

        return view('admin.test.result', ['test' => $test, 'students' => $students]);
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

    public function student(Test $test, Student $student)
    {
        $test->load('questions');

        $questions = $test->questions;

        $answerQuery = DB::table('answers')
            ->select('question_id', 'answer')
            ->where([
                ['test_id', $test->id],
                ['student_id', $student->id]
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

        return view('admin.test.student', [
            'student' => $student,
            'test' => $test,
            'questions' => $questions,
            'answers' => $answers,
            'stats' => $stats
        ]);
    }
}
