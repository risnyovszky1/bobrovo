<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // LOGIN ADMIN / TEACHER
    public function getLogut()
    {
        Auth::logout();
        return redirect()->route('homepage');
    }

    public function getLoginTeacherPage()
    {
        return view('general.login_teacher');
    }

    public function getBadLinkPage()
    {
        return view('admin.badlink');
    }

    public function postLoginTeacherPage(Request $request)
    {
        $this->validate($request, [
                'email' => 'email|required',
                'password' => 'required'
            ]
        );

        $userData = array(
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        );

        if (Auth::attempt($userData)) {
            return redirect()->route('admin');
        }

        return view('general.login_teacher');;
    }

    public function getUcitelAdminPage()
    {
        return view('admin.admin');
    }

    // ---- USERS ----
    public function getAllUsersPage()
    {
        $users = DB::table('users')
            ->leftJoin('students', 'users.id', 'students.teacher_id')
            ->select('users.id', 'users.first_name', 'users.last_name', 'is_admin', 'email', DB::raw('count(students.id) as total'))
            ->orderBy('last_name', 'ASC')->orderBy('first_name', 'ASC')
            ->groupBy('users.id')
            ->get();

        return view('admin.users_all', ['users' => $users]);
    }

    public function getToggleAdminUser($id)
    {

        if ($id != Auth::user()->id) {
            $val = DB::table('users')->select('is_admin')->where('id', $id)->first()->is_admin;

            DB::table('users')
                ->where('id', $id)
                ->update([
                    'is_admin' => $val ? 0 : 1
                ]);
        }

        return redirect()->route('users.all');
    }

    public function getDeleteUser($id)
    {
        if ($id != Auth::user()->id) {
            DB::table('users')->where('id', $id)->delete();
        }

        return redirect()->route('users.all');
    }
}
