<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Yajra\DataTables\Facades\DataTables;

class DataController extends Controller
{
    public function teacher(){
        return DataTables::of(Teacher::all())
            ->addColumn('photo', function ($teacher) { 
            return '<img src="'.$teacher->photo.'" border="0" width="90" class="img-rounded" align="center" />';})
            ->addColumn('action', function ($teacher) {
            return '<a href="/admin/teacher/'.$teacher->id.'/edit" class="btn btn-sm btn-warning btn-circle"><i class="fas fa-check"></i></a>
               <a href="admin/teacher/"'.$teacher->id .'" class="btn btn-sm btn-danger btn-circle"><i class="fas fa-trash"></i></a>';})
            ->rawColumns(['photo', 'action'])->make(true);
    }

    public function student(){
        return DataTables::of(Student::all())
            ->addColumn('photo', function ($student) { 
            return '<img src="'.$student->photo.'" border="0" width="90" class="img-rounded" align="center" />';})
            ->addColumn('action', function ($student) {
            return '<a href="/admin/student/'.$student->id.'/edit" class="btn btn-sm btn-warning btn-circle"><i class="fas fa-check"></i></a>
               <a href="admin/student/"'.$student->id .'" class="btn btn-sm btn-danger btn-circle"><i class="fas fa-trash"></i></a>';})
            ->rawColumns(['photo', 'action'])->make(true);
    }

    public function subject(){
        return DataTables::of(Subject::all())
            ->addColumn('action', function ($subject) {
            return '<a href="/admin/subject/'.$subject->id.'/edit" class="btn btn-sm btn-warning btn-circle"><i class="fas fa-check"></i></a>
               <a href="admin/subject/"'.$subject->id .'" class="btn btn-sm btn-danger btn-circle"><i class="fas fa-trash"></i></a>';})
            ->rawColumns(['action'])->make(true);;
    }
}
