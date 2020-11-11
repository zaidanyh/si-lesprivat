<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherSubject;
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

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $request->merge(['password' => bcrypt($request->password)]);

        Teacher::create($request->all());

        $response = ['message' => 'registered'];
        return response($response, 201);
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
            $response = ['message' => 'failed'];
            return response($response, 422);
        }
    }

    public function logout(Teacher $teacher)
    {
        $teacher->tokens()->delete();

        return response(['message' => 'success'], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, Student $student)
    {
        $teacher_subject = TeacherSubject::with(['teacher', 'subject'])->get();

        $filtered = $teacher_subject->where('subject.name', $request->name)->where('subject.stage', $request->stage);

        $latitude1 = $student->latitude;
        $longitude1 = $student->longitude;

        $map = $filtered->map(function ($items) use ($latitude1, $longitude1) {
            return (object)[
                'id' => $items->id,
                'teacher' => $items->teacher,
                'teacher->distance' => $this->getDistance($latitude1, $longitude1, $items->teacher->latitude, $items->teacher->longitude),
                'subject' => $items->subject,
            ];
        });

        return response($map, 200);
    }

    private function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $earth_radius = 6371;

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return round($d, 2);
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

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->all()], 422);
        }

        $password = is_null($request->password) ? $teacher->password : bcrypt($request->password);
        $request->merge(['password' => $password]);
        $data = $request->except('photo');
        $photo = $request->hasFile('photo') ? cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath() : $teacher->photo;
        $data['photo'] = $photo;

        $teacher->update($data);

        return response(['message' => 'updated'], 200);
    }
}
