<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Teacher;
use PDF;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::with('schedule')->get();

        $hex = ['#2095f2', '#ff532c', '#009b82', '#775949', '#9927b0', '#57be59', '#9b26b2'];
        $map = $attendances->map(function ($items) use ($hex) {
            return (object)[
                'id' => $items->id,
                'title' => $items->schedule->teacher_subject->teacher->name,
                'start' => $items->teaching_date . ' ' . $items->attendance_time,
                'latitude' => $items->latitude,
                'longitude' => $items->longitude,
                'color' => $hex[array_rand($hex)],
            ];
        });

        return view('admin.attendance.index', ['attendances' => $map]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        // return response($attendance);
        return view('admin.attendance.show', ['attendance' => $attendance]);
    }

    public function print(Teacher $teacher)
    {
        $attendances = [];
        $schedules = $teacher->schedules;
        foreach ($schedules as $schedule) {
            $attendances[] = $schedule->attendance;
        }
        
    	$pdf = PDF::loadview('admin.teacher.attendance', ['teacher' => $teacher, 'attendances' => $attendances]);
    	return $pdf->stream();
    }
}
