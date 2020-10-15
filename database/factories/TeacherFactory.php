<?php

namespace Database\Factories;

use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $major = [
            'Pendidikan Matematika',
            'Pendidikan Fisika',
            'Pendidikan Biologi',
            'Pendidikan Kimia',
            'Pendidikan Sejarah',
            'Pendidikan Ekonomi',
            'Pendidikan Geografi',
            'Pendidikan Sosiologi',
            'Pendidikan Ilmu Pengetahuan Alam',
            'Pendidikan Ilmu Pengetahuan Sosial',
            'Pendidikan B. Indonesia',
            'Pendidikan B. Inggris',
            'Pendidikan Guru Sekolah Dasar'
        ];
        $universities = [
            'Universitas Negeri Malang',
            'Universitas Islam Malang',
            'Universitas Muhammadiyah Malang',
            'Universitas Islam Negeri Maulana Malik Ibrahim Malang',
        ];
        $gender = $this->faker->randomElement(['male', 'female']);
        $name = $this->faker->name($gender);
        $domain = ['gmail.com', 'yahoo.com', 'outlook.com', 'icloud.com'];
        $password = bcrypt('123456');

        return [
            'name' => $name,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude(-8.1, -8.2),
            'longitude' => $this->faker->longitude(112.1, 112.2),
            'birth_date' => $this->faker->dateTimeBetween('-29 years', '-19 years'),
            'gender' => $gender == 'male' ? 'Laki-laki' : 'Perempuan',
            'email' => strtolower(str_replace(" ", ".", $name)) . '@' . $domain[array_rand($domain)],
            'password' => $password,
            'education' => 'S1 ' . $major[array_rand($major)] . ' ' . $universities[array_rand($universities)],
            'gpa' => rand(340, 390) / 100,
            'photo' => 'https://res.cloudinary.com/rifaldi/image/upload/v1602240311/default_bawnyo.jpg',
            'created_at' => Carbon::now(),
        ];
    }
}
