<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.student.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $password = bcrypt($request->password);
        $request->merge(['password' => $password]);

        $data = $request->except('photo');
        $photo = cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath();
        $data['photo'] = $photo;

        Student::create($data);
        return redirect()->route('student.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return view('admin.student.show', ['student' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return view('admin.student.edit', ['student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
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
                'email' => $request->email,
                'password' => $request->password != '' ? bcrypt($request->password) : $student->password,
                'class' => $request->class,
                'photo' => $request->hasFile('photo') ? cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath() : $student->photo,
            ]);
        return redirect()->route('student.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        Student::destroy($student->id);
        return redirect()->route('student.index');
    }
}
