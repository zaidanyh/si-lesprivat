<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'teacher_subject';

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }    

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }
}
