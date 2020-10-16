<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $teacher_total = Teacher::all()->count();
        $student_total = Student::all()->count();
        $schedule_total = Schedule::all()->count();
        $attendance_total = Attendance::all()->count();
        
        return view('admin.dashboard', [
            'teacher_total' => $teacher_total,
            'student_total' => $student_total,
            'schedule_total' => $schedule_total,
            'attendance_total' => $attendance_total
        ]);
    }
}
