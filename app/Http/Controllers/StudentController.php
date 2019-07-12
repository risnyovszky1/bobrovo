<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Student;
use Faker\Factory as Faker;
use Auth;

class StudentController extends Controller
{
    // ---- STUDENTS ----

    public function getStudentsPage()
    {
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

    public function postStudentsPage(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'students' => 'required'
        ]);

        foreach ($request->input('students') as $student) {
            $count = DB::table('student_group')->where([
                ['student_id', $student],
                ['group_id', $request->input('group')]
            ])->count();

            if ($count == 0) {
                DB::table('student_group')->insert([
                    'student_id' => $student,
                    'group_id' => $request->input('group')
                ]);
            }
        }

        return redirect()->route('students.all');
    }

    public function getAddStudentPage()
    {
        $groups = DB::table('groups')
            ->select('id', 'name')
            ->where('created_by', Auth::user()->id)
            ->orderBy('name')
            ->get();
        return view('admin.students_add', ['groups' => $groups]);
    }

    public function postAddStudentPage(Request $request)
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

                $count = DB::table('students')->where([
                    ['code', $code]
                ])->count();

                if ($count == 0) {
                    break;
                }
            }

        } else {
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

        if ($request->input('groups') != null) {
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

    public function getStudentProfilPage($id)
    {
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

    public function postAddStudentToGroup(Request $request, $id)
    {
        $this->validate($request, [
            'add-to-group' => 'required'
        ]);

        $count = DB::table('student_group')->where([
            ['student_id', $id],
            ['group_id', $request->input('add-to-group')]
        ])->count();

        if ($count == 0) {
            DB::table('student_group')->insert([
                'student_id' => $id,
                'group_id' => $request->input('add-to-group')
            ]);
        }

        return redirect()->route('students.one', ['id' => $id]);
    }

    public function getStudentDeletePage($id)
    {
        $student = DB::table('students')->select('teacher_id')->where('id', $id)->first();
        if ($student->teacher_id != Auth::user()->id)
            return redirect()->route('badlink');

        DB::table('students')->where('id', $id)->delete();
        return redirect()->route('students.all');
    }

    public function getDeleteFromGroup($sid, $gid)
    {
        $student = DB::table('students')->select('teacher_id')->where('id', $sid)->first();
        $group = DB::table('groups')->select('created_by')->where('id', $gid)->first();

        if ($group->created_by != Auth::user()->id || $student->teacher_id != Auth::user()->id)
            return redirect()->route('badlink');

        DB::table('student_group')->where([
            ['student_id', $sid],
            ['group_id', $gid]])
            ->delete();
        return redirect()->back();
    }

    public function getAddStudentFromFilePage()
    {
        $groups = DB::table('groups')
            ->select('id', 'name')
            ->where('created_by', Auth::user()->id)
            ->orderBy('name', 'ASC')
            ->get();

        return view('admin.students_file', ['groups' => $groups]);
    }

    public function postAddStudentFromFilePage(Request $request)
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
