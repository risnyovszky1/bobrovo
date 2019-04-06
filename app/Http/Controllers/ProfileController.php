<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class ProfileController extends Controller
{
    //
    // ----- PROFILE ----
    public function getProfilPage(){
        return view('admin.profil');
      }
  
      public function postProfilPage(Request $request){
        $user = Auth::user();
    
        $this->validate($request, [
          'first-name' => 'required',
          'last-name' => 'required',
          'email' => 'required|email',
        ]);
  
        $user->first_name = $request->input('first-name');
        $user->last_name = $request->input('last-name');
        $user->email = $request->input('email');
  
        if ($request->input('password')){
          $this->validate($request, [
            'password' => 'required|min:6',
            'password-rpt' => 'required|min:6|required_with:password|same:password'
          ]);
  
          $user->password = bcrypt($request->input('password'));
        }
  
        $user->save();
        
        return redirect()->route('admin.profil');
      }
  
      public function getProfilDeletePage(){
        return view('admin.profil_delete');
      }
  
      public function postProfilDeletePage(){
        $user = User::find(Auth::user()->id);
  
        $user->delete();
  
        return redirect()->route('homepage');
      }
}
