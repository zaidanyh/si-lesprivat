<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Student;
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

        if ($validator->fails())
        {
            return response(['message' => $validator->errors()->all()], 422);
        }

        $request->merge(['password' => bcrypt($request->password)]);
        
        Student::create($request->all());

        return response(['message' =>'registered'], 201);
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

        $student = Student::where('email', $request->email)->first();

        if ($student) {
            if (Hash::check($request->password, $student->password)) {
                $token = $student->createToken('studentTokenApi', ['profile:read', 'profile:update', 'schedule:read'])->plainTextToken;
                return response(['message' => 'success', 'token' => $token], 200);
            } else {
                return response(['message' => 'failed'], 422);
            }
        } else {
            return response(['message' =>'failed'], 422);
        }
    }

    public function logout(Student $student)
    {
        $student->tokens()->delete();
        
        return response(['message' =>'success'], 200);
    }

    public function schedules(Student $student)
    {
        return response($student->schedules, 200);
    }
    
    public function schedule(Student $student, Schedule $schedule)
    {
        return response($schedule, 200);
    }

    public function search(Request $request, Student $student)
    {
        $teacher_subject = TeacherSubject::with(['teacher', 'subject'])->get();
        
        $filtered = $teacher_subject->where('subject.name', $request->name)->where('subject.stage', $request->stage);
        
        $latitude1 = $student->latitude;
        $longitude1 = $student->longitude;

        $map = $filtered->map(function ($items) use ($latitude1, $longitude1) {
            $data = (object)[];

            $data->id = $items->id;
            $data->teacher = $items->teacher;
            $latitude2 = $data->teacher->latitude;
            $longitude2 = $data->teacher->longitude;
            $data->teacher->distance = $this->getDistance($latitude1, $longitude1, $latitude2, $longitude2);
            $data->subject = $items->subject;

            return $data;
        });

        return response($map, 200);
    }

    private function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {  
        $earth_radius = 6371;  
          
        $dLat = deg2rad($latitude2 - $latitude1);  
        $dLon = deg2rad($longitude2 - $longitude1);  
          
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
        $c = 2 * asin(sqrt($a));  
        $d = $earth_radius * $c;  
          
        return round($d * 100);  
    }  

    public function appointment(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:"Y-m-d"',
            'start_time' => 'required|date_format:"H:i:s"',
            'end_time' => 'required|date_format:"H:i:s"',
            'teacher_subject_id' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $request->merge(['student_id' => $student->id]);

        Schedule::create($request->all());

        return response(['message' =>'created'],201);
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

        if ($validator->fails())
        {
            return response(['message' => $validator->errors()->all()], 422);
        }

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

        return response(['message' =>'updated'], 200);
    }
}
