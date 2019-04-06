<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use Illuminate\Support\Facades\DB;
use App\Student;
use Auth;

class GroupController extends Controller
{
    // ---- GROUPS -----

    public function getGroupsPage(){
        $db = DB::table('groups')
          ->select('id', 'name', 'created_at')
          ->where('created_by', Auth::user()->id)
          ->orderBy('name')
          ->get();
  
        $groups = array();
        foreach ($db as $item) {
          $record = array(
            'id' => $item->id, 
            'name' => $item->name,
            'created_at' => $item->created_at,
            'total_students' => DB::table('student_group')->where('group_id', $item->id)->count()
          );
  
          $groups[] = $record;
        }
        return view('admin.groups_all', ['groups' => $groups]);
      }
  
      public function getAddGroupPage(){
        return view('admin.groups_add');
      }
  
      public function postAddGroupPage(Request $request){
        $this->validate($request,[
          'title' => 'required|min:6',
          'desc' => 'required|min:10'
        ]);
  
        $group = new Group([
          'name' => $request->input('title'),
          'description' => $request->input('desc'),
          'created_by' => Auth::user()->id
        ]);
  
        $group->save();
  
        return view('admin.groups_add', ['success' => 'Skupina bola úspešne pridaná.']);
      }
      
      public function getDeleteGroup($id){
        $group = DB::table('groups')->select('created_by')->where('id', $id)->first();
        if ($group->created_by != Auth::user()->id)
          return redirect()->route('badlink');
  
        DB::table('groups')->where('id', $id)->delete();
        return redirect()->route('groups.all');
      }
  
      public function getGroupOnePage($id){
        $group = DB::table('groups')->where('id', $id)->first();
        $students = DB::table('student_group')
          ->join('students', 'students.id', 'student_group.student_id')
          ->select('students.id', 'students.first_name', 'students.last_name')
          ->where('student_group.group_id', $id)
          ->get();
  
  
        return view('admin.groups_one', ['group' => $group, 'students' => $students]);
      }
  
      public function getEditGroupPage($id){
        $group = DB::table('groups')->where('id', $id)->first();
        return view('admin.groups_edit', ['group' => $group]);
      }
  
      public function postEditGroupPage(Request $request, $id){
        $this->validate($request, [
          'title' => 'required',
          'desc' => 'required'
        ]);
  
        DB::table('groups')->where('id', $id)->update([
          'name' => $request->input('title'),
          'description' => $request->input('desc'),
          'updated_at' => date('Y-m-d H:i:s')
        ]);
  
  
        $group = DB::table('groups')->where('id', $id)->first();
        return view('admin.groups_edit', ['group' => $group, 'success' => 'Úpravy boli uložené!']);
      }
}
