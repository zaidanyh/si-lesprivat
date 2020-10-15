<?php

namespace Database\Factories;

use App\Models\TeacherSubject;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherSubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TeacherSubject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'teacher_id' => rand(1, 50),
            'subject_id' => rand(1, 17),
            'created_at' => Carbon::now(),
        ];
    }
}
