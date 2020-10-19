<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }

    public function attendance()
    {
        return $this->hasOne('App\Models\Attendance');
    }

    public function teacher_subject()
    {
        return $this->belongsTo('App\Models\TeacherSubject');
    }
}
