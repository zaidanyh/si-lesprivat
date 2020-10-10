<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            'name' => 'B. Indonesia',
            'stage' => 'SD',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'Matematika',
            'stage' => 'SD',
            'created_at' => Carbon::now(),
        ]);
        DB::table('subjects')->insert([
            'name' => 'Ilmu Pengetahuan Alam',
            'stage' => 'SD',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'Matematika',
            'stage' => 'SMP',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'B. Indonesia',
            'stage' => 'SMP',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'B. Inggris',
            'stage' => 'SMP',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'Ilmu Pengetahuan Alam',
            'stage' => 'SMP',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'Ilmu Pengetahuan Sosial',
            'stage' => 'SMP',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'Matematika',
            'stage' => 'SMA',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'Bahasa Indonesia',
            'stage' => 'SMA',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'Bahasa Inggris',
            'stage' => 'SMA',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'Fisika',
            'stage' => 'SMA',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'Kimia',
            'stage' => 'SMA',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'Biologi',
            'stage' => 'SMA',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'Ekonomi',
            'stage' => 'SMA',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'Sejarah',
            'stage' => 'SMA',
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'Geografi',
            'stage' => 'SMA',
            'created_at' => Carbon::now()
        ]);
    }
}
