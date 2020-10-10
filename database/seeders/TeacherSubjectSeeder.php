<?php

namespace Database\Seeders;

use App\Models\TeacherSubject;
use Illuminate\Database\Seeder;

class TeacherSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TeacherSubject::factory()->times(10)->create();
    }
}
