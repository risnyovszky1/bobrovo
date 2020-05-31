<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
            $this->flashMsg('Úspešne ste upravili používateľa!');
        }

        return redirect()->route('user.index');
    }

    public function destroy(User $user)
    {
        if ($user->id != Auth::user()->id) {
            $user->delete();
            $this->flashMsg('Úspešne ste vymazali používateľa!');
        }

        return redirect()->route('user.index');
    }


    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:6|required_with:password-rpt|same:password-rpt',
            'password-rpt' => 'required|min:6',
            'is_admin' => 'nullable|in:yes,no',
        ]);

        $user = new User([
            'email' => $request->input('email'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'password' => bcrypt($request->input('password')),
            'is_admin' => $request->input('is_admin', 'no') == 'yes',
        ]);

        $user->save();

        return redirect()->route('user.index');
    }
}
