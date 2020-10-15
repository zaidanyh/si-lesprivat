<?php

namespace Database\Factories;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attendance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $schedule = 1;

        return [
            'teaching_date' => $this->faker->dateTimeBetween('-45 days', '-1 days'),
            'attendance_time' => $this->faker->dateTimeBetween('-45 days', '-1 days'),
            'leave_time' => $this->faker->dateTimeBetween('-45 days', '-1 days'),
            'latitude' => $this->faker->latitude(-8.1, -8.2),
            'longitude' => $this->faker->longitude(-112.1, 112.2),
            'schedule_id' => $schedule++,
            'status' => $this->faker->randomElement(['Tepat Waktu', 'Terlambat']),
            'created_at' => Carbon::now(),
        ];
    }
}
