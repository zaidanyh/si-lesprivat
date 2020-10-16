<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;

class TeacherSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TeacherSubject  $teacherSubject
     * @return \Illuminate\Http\Response
     */
    public function show(TeacherSubject $teacherSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TeacherSubject  $teacherSubject
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        $subjects = Subject::all();
        return view('admin.teacher_subject.edit', ['teacher' => $teacher, 'subjects' => $subjects]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TeacherSubject  $teacherSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $teacher->subjects()->sync($request->subject_ids);

        return redirect()->route('teacher.show', $teacher);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeacherSubject  $teacherSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeacherSubject $teacherSubject)
    {
        //
    }
}
