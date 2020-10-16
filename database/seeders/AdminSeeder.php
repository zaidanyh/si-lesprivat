<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Nisauz Zahroul Aini',
            'email' => 'nisauzahr@gmail.com',
            'password' => Hash::make('081335743751'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('admins')->insert([
            'name' => 'Noviar Graha Andika',
            'email' => 'noviargr@gmail.com',
            'password' => Hash::make('087874439827'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('admins')->insert([
            'name' => 'Muhamad Zaidan Yahya',
            'email' => 'mzaidanyh26@gmail.com',
            'password' => Hash::make('085745966039'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('admins')->insert([
            'name' => 'Rifaldi Dwi Distika W',
            'email' => 'dwi.rifaldi2588@gmail.com',
            'password' => Hash::make('085735725135'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('admins')->insert([
            'name' => 'Shania Bunga Amalia',
            'email' => 'nia455@gmail.com',
            'password' => Hash::make('085536724154'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
