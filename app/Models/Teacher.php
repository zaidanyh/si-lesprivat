<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    public function subjects()
    {
        return $this->belongsToMany(
            'App\Models\Subject', 
            'teacher_subject', 
            'teacher_id', 
            'subject_id'
        );
    }

    public function schedules()
    {
        return $this->hasManyThrough(
            'App\Models\Schedule', 
            'App\Models\TeacherSubject', 
            'teacher_id', 
            'teacher_subject_id'
        );
    }
}
