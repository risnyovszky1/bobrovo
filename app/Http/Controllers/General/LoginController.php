<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function getLoginTeacherPage()
    {
        return view('general.login_teacher');
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

        return view('general.login_teacher');
    }

    // LOGIN STUDENTS - APP
    public function getLoginStudentPage()
    {
        return view('general.login_student');
    }

    public function postLoginStudentPage(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|exists:students,code',
        ]);

        $code = $request->input('code');
        $sid = DB::table('students')->select('id', 'code')->where('code', $code)->first();

        if (Auth::guard('bobor')->loginUsingId($sid->id)) {
            return redirect()->route('student_home');
        }

        return view('general.login_student', ['success' => 'No id found']);
    }
}
