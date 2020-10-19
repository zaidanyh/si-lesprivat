<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

        $response = ['message' =>'Register teacher success'];
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
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $teacher = Teacher::where('email', $request->email)->first();

        if ($teacher) {
            if (Hash::check($request->password, $teacher->password)) {
                $token = $teacher->createToken('teacherTokenApi', ['profile:read', 'profile:update', 'schedule:read', 'attendance:create'])->plainTextToken;
                $response = ['message' => 'Login Teacher Success', 'id' => $teacher->id, 'token' => $token];
                return response($response, 200);
            } else {
                $response = ['message' => 'Password mismatch'];
                return response($response, 422);
            }
        } else {
            $response = ['message' =>'User does not exist'];
            return response($response, 422);
        }
    }

    public function logout(Teacher $teacher)
    {
        $teacher->tokens()->delete();
        
        return response(['message' =>'Logout Teacher Success'], 200);
    }

    public function schedule(Teacher $teacher)
    {
        $schedules = $teacher->schedules;
        return response($schedules, 200);
    }

    public function schedule_detail(Teacher $teacher, Schedule $schedule)
    {
        return response($schedule, 200);
    }

    public function attendance(Request $request, Teacher $teacher, Schedule $schedule)
    {
        # code...
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

        return response(['message' =>'Update Teacher Profile Success'], 200);
    }
}
