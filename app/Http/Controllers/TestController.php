<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
        // LOGIN STUDENTS - APP
        public function getLoginStudentPage(){
            return view('general.login_student');
          }
}
