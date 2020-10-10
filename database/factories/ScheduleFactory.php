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
            'date' => $this->faker->dateTimeBetween('-7 days', '-1 days'),
            'time_start' => $this->faker->dateTimeBetween('-7 days', '-1 days'),
            'time_end' => $this->faker->dateTimeBetween('-7 days', '-1 days'),
            'student_id' => rand(1, 15),
            'teacher_subject_id' => rand(1, 10),
            'status' => $this->faker->randomElement(['Tepat Waktu', 'Terlambat']),
            'created_at' => Carbon::now(),
        ];
    }
}
