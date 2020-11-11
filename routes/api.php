<?php

use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\SubjectController;
use App\Http\Controllers\API\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('teacher')->group(function () {
    Route::post('register', [TeacherController::class, 'register']);
    Route::post('login', [TeacherController::class, 'login']);
    Route::post('{teacher}/logout', [TeacherController::class, 'logout']);
});

Route::prefix('student')->group(function () {
    Route::post('register', [StudentController::class, 'register']);
    Route::post('login', [StudentController::class, 'login']);
    Route::post('{student}/logout', [StudentController::class, 'logout']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('subject', [SubjectController::class, 'index'])->name('all.subject');
    Route::get('schedule/{schedule}', [ScheduleController::class, 'show'])->name('schedule.detail');
    Route::post('schedule/{schedule}/attendance/{attendance}', [AttendanceController::class, 'store'])->name('schedule.attendance');
    Route::get('attendance/{attendance}', [AttendanceController::class, 'show'])->name('attendance.detail');

    Route::prefix('teacher')->group(function () {
        Route::get('/{teacher}', [TeacherController::class, 'show'])->name('teacher.show.profile');
        Route::put('/{teacher}', [TeacherController::class, 'update'])->name('teacher.edit.profile');
        Route::get('/{teacher}/schedule', [ScheduleController::class, 'index'])->name('teacher.schedule');
        Route::get('/{teacher}/attendance', [AttendanceController::class, 'index'])->name('teacher.attendance');
    });

    Route::prefix('student')->group(function () {
        Route::get('/{student}', [StudentController::class, 'show'])->name('student.show.profile');
        Route::put('/{student}', [StudentController::class, 'update'])->name('student.edit.profile');
        Route::get('/{student}/search/teacher', [TeacherController::class, 'search'])->name('search.teacher');
        Route::get('/{student}/schedule', [ScheduleController::class, 'index'])->name('student.schedule');
        Route::post('/{student}/schedule', [ScheduleController::class, 'index'])->name('add.schedule');
    });
});
