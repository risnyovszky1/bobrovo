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
    public function index()
    {
        $users = User::with('students')
            ->orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.user.list', ['users' => $users]);
    }

    public function toggle(User $user)
    {
        if ($user->id != Auth::user()->id) {
            $user->update([
                'is_admin' => !$user->is_admin,
            ]);
        }

        return redirect()->route('user.index');
    }

    public function destroy(User $user)
    {
        if ($user->id != Auth::user()->id) {
            $user->delete();
        }

        return redirect()->route('user.index');
    }
}
