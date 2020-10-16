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
                return '<img src="' . $teacher->photo . '" border="0" width="90" class="img-rounded" align="center" />';
            })
            ->addColumn('action', function ($teacher) {
                return '<a href="/admin/teacher/' . $teacher->id . '" class="btn btn-sm btn-info btn-circle"><i class="fas fa-info-circle"></i></a>
               <a href="/admin/teacher/' . $teacher->id . '/edit" class="btn btn-sm btn-warning btn-circle"><i class="fas fa-check"></i></a>
               <form action="/admin/teacher/' . $teacher->id . '" method="POST" class="d-inline">
                    <input type="hidden" name="_method" value="delete" />
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <button class="btn btn-sm btn-danger btn-circle" type="submit"><i class="fas fa-trash"></i></button>
                </form>';
            })
            ->rawColumns(['photo', 'action'])->make(true);
    }

    public function student()
    {
        return DataTables::of(Student::all())
            ->addIndexColumn()
            ->addColumn('photo', function ($student) {
                return '<img src="' . $student->photo . '" border="0" width="90" class="img-rounded" align="center" />';
            })
            ->addColumn('action', function ($student) {
                return '<a href="/admin/student/' . $student->id . '" class="btn btn-sm btn-info btn-circle"><i class="fas fa-info-circle"></i></a>
                <a href="/admin/student/' . $student->id . '/edit" class="btn btn-sm btn-warning btn-circle"><i class="fas fa-check"></i></a>
                <form action="/admin/student/' . $student->id . '" method="POST" class="d-inline">
                        <input type="hidden" name="_method" value="delete" />
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <button class="btn btn-sm btn-danger btn-circle" type="submit"><i class="fas fa-trash"></i></button>
                </form>';
            })
            ->rawColumns(['photo', 'action'])->make(true);
    }

    public function subject()
    {
        return DataTables::of(Subject::all())
            ->addIndexColumn()
            ->addColumn('action', function ($subject) {
                return '<a href="/admin/subject/' . $subject->id . '/edit" class="btn btn-sm btn-warning btn-circle"><i class="fas fa-check"></i></a>
                <form action="/admin/subject/' . $subject->id . '" method="POST" class="d-inline">
                    <input type="hidden" name="_method" value="delete" />
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <button class="btn btn-sm btn-danger btn-circle" type="submit"><i class="fas fa-trash"></i></button>
                </form>';
            })
            ->rawColumns(['action'])->make(true);;
    }
}
