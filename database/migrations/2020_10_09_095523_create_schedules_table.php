<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time_start');
            $table->time('time_end');
            $table->foreignId('student_id')->constrained();
            $table->foreignId('teacher_subject_id')->constrained('teacher_subject');
            $table->enum('status', ['Belum Dimulai', 'Tepat Waktu', 'Terlambat'])->default('Belum Dimulai');	
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
