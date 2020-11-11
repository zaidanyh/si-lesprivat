<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Models\TeacherSubject;
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

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->all()], 422);
        }

        $request->merge(['password' => bcrypt($request->password)]);

        Student::create($request->all());

        return response(['message' => 'registered'], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->all()], 422);
        }

        $student = Student::where('email', $request->email)->first();

        if ($student) {
            if (Hash::check($request->password, $student->password)) {
                $token = $student->createToken('studentTokenApi', ['profile:read', 'profile:update', 'schedule:read'])->plainTextToken;
                return response(['message' => 'success', 'id' => $student->id, 'token' => $token], 200);
            } else {
                return response(['message' => 'failed'], 422);
            }
        } else {
            return response(['message' => 'failed'], 422);
        }
    }

    public function logout(Student $student)
    {
        $student->tokens()->delete();

        return response(['message' => 'success'], 200);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:5|max:255',
            'phone' => 'required|string',
            'address' => 'required|string|min:10|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
            'birth_date' => 'required|date_format:"Y-m-d"',
            'class' => 'required|string|min:10|max:255',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->all()], 422);
        }

        $password = is_null($request->password) ? $student->password : bcrypt($request->password);
        $request->merge(['password' => $password]);
        $data = $request->except('photo');
        $photo = $request->hasFile('photo') ? cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath() : $student->photo;
        $data['photo'] = $photo;

        $student->update($request->all());

        return response(['message' => 'updated'], 200);
    }
}
