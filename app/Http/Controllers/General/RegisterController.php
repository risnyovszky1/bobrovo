<?php

namespace App\Http\Controllers\General;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    // REGISTER
    public function register()
    {
        return view('general.register');
    }

    public function sendRegistration(Request $request)
    {
        $this->validate($request, [
            'first-name' => 'required',
            'last-name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:6|required_with:password-rpt|same:password-rpt',
            'password-rpt' => 'required|min:6',
            'default-conditions' => 'required',
        ]);

        $newUser = new User([
            'email' => $request->input('email'),
            'first_name' => $request->input('first-name'),
            'last_name' => $request->input('last-name'),
            'password' => bcrypt($request->input('password')),
            'is_admin' => false,
        ]);

        $newUser->save();

        return redirect()->route('register')->with(['message' => 'Úspešná registrácia!']);
    }
}
