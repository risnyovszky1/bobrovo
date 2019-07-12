<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;
use Auth;

class PdfController extends Controller
{
    //

    public function getStudentsPdfExport()
    {
        $students = DB::table('students')
            ->select('last_name', 'first_name', 'code')
            ->where('teacher_id', Auth::user()->id)
            ->orderBy('last_name', 'ASC')
            ->orderBy('first_name', 'ASC')
            ->get();

        $name = 'Bobrovo';
        Session::put('printDocName', null);

        return $this->streamStudentsToPdf($students, $name);
    }

    public function getStudentsInGroupPdfExport($id)
    {
        $students = DB::table('student_group')
            ->join('students', 'student_group.student_id', 'students.id')
            ->select('first_name', 'last_name', 'code')
            ->where('group_id', $id)
            ->orderBy('last_name', 'ASC')
            ->orderBy('first_name', 'ASC')
            ->get();


        $name = DB::table('groups')->select('name')->where('id', $id)->first()->name;

        return $this->streamStudentsToPdf($students, $name);
    }

    public function streamStudentsToPdf($students, $name)
    {
        Session::put('printDocName', $name);
        Session::put('userStudents', $students);

        $data = [
            'foo' => 'bar',
        ];

        $pdf = PDF::loadView('pdf.students', $data, [], [
            'format' => 'A4',
            'author' => 'Bobrovo',
            'creator' => 'Web Bobrovo Pdf',
        ]);

        return $pdf->stream('document.pdf');
    }
}
