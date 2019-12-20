<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // LOGIN ADMIN / TEACHER
    public function getLogout()
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
        $users = User::with('students')
            ->orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
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
