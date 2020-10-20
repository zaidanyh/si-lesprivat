<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Yajra\DataTables\Facades\DataTables;

class DataController extends Controller
{
    public function teacher()
    {
        return DataTables::of(Teacher::all())
            ->addIndexColumn()
            ->addColumn('photo', function ($teacher) {
                return view('layouts.components.image', ['teacher' => $teacher]);
            })
            ->addColumn('action', function ($teacher) {
                return view('layouts.components.button', ['teacher' => $teacher]);
            })
            ->rawColumns(['photo', 'action'])->make(true);
    }

    public function student()
    {
        return DataTables::of(Student::all())
            ->addIndexColumn()
            ->addColumn('photo', function ($student) {
                return view('layouts.components.image', ['student' => $student]);
            })
            ->addColumn('action', function ($student) {
                return view('layouts.components.button', ['student' => $student]);
            })
            ->rawColumns(['photo', 'action'])->make(true);
    }

    public function subject()
    {
        return DataTables::of(Subject::all())
            ->addIndexColumn()
            ->addColumn('action', function ($subject) {
                return view('layouts.components.button', ['subject' => $subject]);
            })
            ->rawColumns(['action'])->make(true);;
    }
}
