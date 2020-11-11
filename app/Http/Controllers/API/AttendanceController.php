<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Teacher $teacher)
    {
        $attendances = [];
        $schedules = $teacher->schedules;
        foreach ($schedules as $schedule) {
            $attendances[] = $schedule->attendance;
        }

        return response($attendances, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Teacher $teacher, Schedule $schedule)
    {
        $validator = Validator::make($request->all(), [
            'teaching_date' => 'required|date_format:"Y-m-d"',
            'attendance_time' => 'required|date_format:"H:i:s"',
            'leave_time' => 'required|date_format:"H:i:s"',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->all()], 422);
        }

        $status = $this->checkAttendance(
            $request->teaching_date,
            $request->attendance_time,
            $request->leave_time,
            $schedule->date,
            $schedule->start_time,
            $schedule->end_time
        );

        $request->merge(['schedule_id' => $schedule->id, 'status' => $status]);

        Attendance::create($request->all());

        return response(['message' => 'created'], 201);
    }

    private function checkAttendance($teaching_date, $attendance_time, $leave_time, $schedule_date, $schedule_start_time, $schedule_end_time)
    {
        if ($teaching_date ==  $schedule_date && $attendance_time < $schedule_start_time && $leave_time > $schedule_end_time) {
            return 'Tepat Waktu';
        }
        return 'Terlambat';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        return response($attendance, 200);
    }
}
