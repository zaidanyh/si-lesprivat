<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public function teachers()
    {
        return $this->belongsToMany(
            'App\Models\Teacher', 
            'teacher_subject', 
            'subject_id', 
            'teacher_id'
        );
    }

    public function schedules()
    {
        return $this->hasManyThrough(
            'App\Models\Schedule', 
            'App\Models\TeacherSubject', 
            'subject_id', 
            'teacher_subject_id'
        );
    }
}
