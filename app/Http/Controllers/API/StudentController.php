<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
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
        
        Student::create($request->all());

        return response(['message' =>'Register student success'], 201);
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

        $student = Student::where('email', $request->email)->first();

        if ($student) {
            if (Hash::check($request->password, $student->password)) {
                $token = $student->createToken('studentTokenApi', ['profile:read', 'profile:update', 'schedule:read'])->plainTextToken;
                return response(['message' => 'Login Success', 'token' => $token], 200);
            } else {
                return response(['message' => 'Password mismatch'], 422);
            }
        } else {
            return response(['message' =>'User does not exist'], 422);
        }
    }

    public function logout(Student $student)
    {
        $student->tokens()->delete();
        
        return response(['message' =>'Logout Student Success'], 200);
    }

    public function schedule(Student $student)
    {
        return response($student->schedules, 200);
    }
    
    public function schedule_detail(Student $student, Schedule $schedule)
    {
        return response($schedule, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return response($student, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        Student::where('id', $student->id)
        ->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'birth_date' => $request->birth_date,
            'password' => $request->password != '' ? bcrypt($request->password) : $student->password,
            'class' => $request->class,
            'photo' => $request->hasFile('photo') ? cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath() : $student->photo,
        ]);

        return response(['message' =>'Update Student Profile Success'], 200);
    }
}
