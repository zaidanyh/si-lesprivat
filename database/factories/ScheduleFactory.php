<?php

namespace Database\Factories;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween('-45 days', '-1 days'),
            'start_time' => $this->faker->dateTimeBetween('-45 days', '-1 days'),
            'end_time' => $this->faker->dateTimeBetween('-45 days', '-1 days'),
            'student_id' => rand(1, 50),
            'teacher_subject_id' => rand(1, 50),
            'created_at' => Carbon::now(),
        ];
    }
}
