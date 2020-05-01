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
