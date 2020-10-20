<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Student;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Schedule::all();
        $students = Student::all();
        $teacher_subjects = TeacherSubject::all();

        $hex = ['#2095f2', '#ff532c', '#009b82', '#775949', '#9927b0', '#57be59', '#9b26b2'];
        $map = $schedules->map(function ($items) use ($hex) {
            return (object)[
                'id' => $items->id,
                'title' => $items->student->name,
                'start' => $items->date . ' ' . $items->start_time,
                'end' => $items->date . ' ' . $items->end_time,
                'student' => $items->student->id,
                'teacher' => $items->teacher_subject->teacher->id,
                'color' => $hex[array_rand($hex)],
            ];
        });

        return view('admin.schedule.index', ['schedules' => $map, 'students' => $students, 'teacher_subjects' => $teacher_subjects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Schedule::updateOrCreate(
            ['id' => $request->id],
            [
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'student_id' => $request->student_id,
                'teacher_subject_id' => $request->teacher_subject_id,
            ]
        );
        return redirect()->route('schedule.index')->with(['success' => 'Data Berhasil Ditambahkan']);
    }
}
