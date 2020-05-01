<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    //
    // ----- PROFILE ----
    public function edit()
    {
        return view('admin.profil.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'first-name' => 'required',
            'last-name' => 'required',
            'email' => 'required|email',
        ]);

        $user->first_name = $request->input('first-name');
        $user->last_name = $request->input('last-name');
        $user->email = $request->input('email');

        if ($request->input('password')) {
            $this->validate($request, [
                'password' => 'required|min:6',
                'password-rpt' => 'required|min:6|required_with:password|same:password'
            ]);

            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->route('profil.edit');
    }

    public function destroy()
    {
        $user = Auth::user();

        Auth::logout();

        $user->delete();

        return redirect()->route('index');
    }
}
