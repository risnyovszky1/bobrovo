<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Student;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // ---- STUDENTS ----

    public function index()
    {
        $students = Student::query()
            ->where('teacher_id', Auth::user()->id)
            ->orderBy('last_name', 'ASC')
            ->orderBy('first_name', 'ASC')
            ->get();
        $groups = Group::query()
            ->where('created_by', Auth::user()->id)
            ->orderBy('name')
            ->get();
        return view('admin.student.list', ['students' => $students, 'groups' => $groups]);
    }

    public function addStudentsToGroup(Request $request)
    {
        $this->validate($request, [
            'group' => 'required|exists:groups,id',
            'students' => 'required'
        ]);

        foreach ($request->input('students') as $studentId) {
            $student = Student::query()->find($studentId);

            if (!$student->groups()->where('id', $request->input('group'))->exists()) {
                $student->groups()->attach($request->input('group'));
            }
        }

        return redirect()->route('student.index');
    }

    public function create()
    {
        $groups = Group::query()
            ->where('created_by', Auth::user()->id)
            ->orderBy('name')
            ->get();
        return view('admin.student.create', ['groups' => $groups]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first-name' => 'required|min:3',
            'last-name' => 'required|min:3'
        ]);

        $code = '';
        if ($request->input('generate-random-code') != null) {
            $faker = Faker::create();
            while (true) {
                $code = $faker->bothify('**********');

                if (!Student::query()->where('code', $code)->exists()) {
                    break;
                }
            }

        } else {
            $this->validate($request, [
                'code' => 'min:6|max:15|unique:students,code'
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

        $this->flashMsg('Úspešne ste pridali žiaka!');

        return view('admin.student.show', $student);
    }

    public function show(Student $student)
    {
        $student->load('groups');

        $groupList = Group::query()
            ->where('created_by', Auth::user()->id)
            ->orderBy('name')
            ->get();

        return view('admin.student.show', ['student' => $student, 'groupList' => $groupList]);
    }

    public function update(Request $request, Student $student)
    {
        $this->validate($request, [
            'add-to-group' => 'required|exists:groups,id'
        ]);

        if (!$student->groups()->where('id', $request->input('add-to-group'))->exists()) {
            $student->groups()->attach($request->input('add-to-group'));
        }

        return redirect()->route('student.show', $student);
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('student.index');
    }

    public function removeFromGroup(Student $student, Group $group)
    {
        $student->groups()->detach($group->id);

        return redirect()->back();
    }

    public function import()
    {
        $groups = Group::query()
            ->where('created_by', Auth::user()->id)
            ->orderBy('name', 'ASC')
            ->get();

        return view('admin.student.import', ['groups' => $groups]);
    }

    public function importSave(Request $request)
    {
        $this->validate($request, [
            'student_file' => 'required'
        ]);

        $group_id = $request->input('group');

        $file = File::get($request->file('student_file')->getRealPath());

        $count = 0;
        $tmp = 0;
        foreach (explode("\n", $file) as $line) {
            $data = explode(',', $line);

            if (count($data) != 3) continue;

            $student = new Student([
                'first_name' => $data[0],
                'last_name' => $data[1],
                'code' => $data[2],
                'teacher_id' => Auth::user()->id
            ]);

            $student->save();
            if ($group_id != '') {
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
            'success' => 'Úsprešne ste pridali ' . $count . ' žiakov!',
            'file' => $tmp,
            'groups' => $groups
        ]);;
    }
}
