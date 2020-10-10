<?php

namespace Database\Seeders;

use Database\Factories\TeacherSubjectFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(TeacherSubjectSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(AttendanceSeeder::class);
    }
}
