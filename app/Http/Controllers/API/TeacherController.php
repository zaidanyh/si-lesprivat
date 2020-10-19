<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $request->merge(['password' => bcrypt($request->password)]);
        
        Teacher::create($request->all());

        $response = ['message' =>'registered'];
        return response($response, 201);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails())
        {
            return response(['message' => $validator->errors()->all()], 422);
        }

        $teacher = Teacher::where('email', $request->email)->first();

        if ($teacher) {
            if (Hash::check($request->password, $teacher->password)) {
                $token = $teacher->createToken('teacherTokenApi', ['profile:read', 'profile:update', 'schedule:read', 'attendance:create'])->plainTextToken;
                $response = ['message' => 'success', 'id' => $teacher->id, 'token' => $token];
                return response($response, 200);
            } else {
                $response = ['message' => 'failed'];
                return response($response, 422);
            }
        } else {
            $response = ['message' =>'failed'];
            return response($response, 422);
        }
    }

    public function logout(Teacher $teacher)
    {
        $teacher->tokens()->delete();
        
        return response(['message' =>'success'], 200);
    }

    public function schedules(Teacher $teacher)
    {
        $schedules = $teacher->schedules;
        return response($schedules, 200);
    }

    public function schedule(Teacher $teacher, Schedule $schedule)
    {
        return response($schedule, 200);
    }

    public function schedule_attendance(Request $request, Teacher $teacher, Schedule $schedule)
    {
        $validator = Validator::make($request->all(), [
            'teaching_date' => 'required|date_format:"Y-m-d"',
            'attendance_time' => 'required|date_format:"H:i:s"',
            'leave_time' => 'required|date_format:"H:i:s"',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response(['message' => $validator->errors()->all()], 422);
        }

        $teaching_date = $request->teaching_date;
        $attendance_time = $request->attendance_time;
        $leave_time = $request->leave_time;
        $schedule_date = $schedule->date;
        $schedule_start_time = $schedule->start_time;
        $schedule_end_time = $schedule->end_time;

        $status = $this->check_attendance($teaching_date, $attendance_time, $leave_time,
                                            $schedule_date, $schedule_start_time, $schedule_end_time);

        $request->merge(['schedule_id' => $schedule->id, 'status' => $status]);

        Attendance::create($request->all());

        return response(['message' =>'created'], 201);
    }

    private function check_attendance($teaching_date, $attendance_time, $leave_time, $schedule_date, $schedule_start_time, $schedule_end_time)
    {
        if ($teaching_date ==  $schedule_date && $attendance_time < $schedule_start_time && $leave_time > $schedule_end_time) {
            return 'Tepat Waktu';
        }
        return 'Terlambat';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        return response($teacher, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:5|max:255',
            'phone' => 'required|string',
            'address' => 'required|string|min:10|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
            'birth_date' => 'required|date_format:"Y-m-d"',
            'education' => 'required|string|min:10|max:255',
            'gpa' => 'required|string|min:4|max:4',
        ]);
        
        if ($validator->fails())
        {
            return response(['message' => $validator->errors()->all()], 422);
        }

        Teacher::where('id', $teacher->id)
        ->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'birth_date' => $request->birth_date,
            'password' => $request->password != '' ? bcrypt($request->password) : $teacher->password,
            'education' => $request->education,
            'gpa' => $request->gpa,
            'photo' => $request->hasFile('photo') ? cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath() : $teacher->photo,
        ]);

        return response(['message' =>'updated'], 200);
    }
}
