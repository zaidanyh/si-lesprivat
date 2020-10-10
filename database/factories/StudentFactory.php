<?php

namespace Database\Factories;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $stage = ['SD', 'SMP', 'SMA'];
        $gender = $this->faker->randomElement(['male', 'female']);
        $name = $this->faker->name($gender);
        $domain = ['gmail.com', 'yahoo.com', 'outlook.com', 'icloud.com'];

        return [
            'name' => $name,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude(-8.1, -8.2),
            'longitude' => $this->faker->longitude(112.1, 112.2),
            'birth_date' => $this->faker->dateTimeBetween('-19 years', '-9 years'),
            'gender' => $gender == 'male' ? 'Laki-laki' : 'Perempuan',
            'email' => strtolower(str_replace(" ", ".", $name)) . '@' . $domain[array_rand($domain)],
            'password' => bcrypt('123456'),
            'stage' => $stage[array_rand($stage)],
            'photo' => 'https://res.cloudinary.com/rifaldi/image/upload/v1602240311/default_bawnyo.jpg',
            'created_at' => Carbon::now(),
        ];
    }
}
