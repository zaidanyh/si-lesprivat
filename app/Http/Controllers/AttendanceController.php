<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::all();

        $map = $attendances->map(function ($items) {
            $hex = ['#2095f2', '#ff532c', '#009b82', '#775949', '#9927b0', '#57be59', '#9b26b2'];
            $data = (object)[];

            $data->title = $items->schedule->teacher_subject->teacher->name;
            $data->start = $items->teaching_date . ' ' . $items->attendance_time;
            $data->color = $hex[array_rand($hex)];

            return $data;
        });

        return view('admin.attendance.index', ['attendances' => $map]);
    }
}
