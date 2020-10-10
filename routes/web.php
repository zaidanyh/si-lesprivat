<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes(['register' => false]);

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resources([
        'teacher' => TeacherController::class,
        'student' => StudentController::class,
        'subject' => SubjectController::class,
        'schedule' => ScheduleController::class,
        'attendance' => AttendanceController::class,
    ]);
});

Route::prefix('json')->middleware('auth')->group(function () {
    Route::get('teacher', [DataController::class, 'teacher']);
    Route::get('student', [DataController::class, 'student']);
    Route::get('subject', [DataController::class, 'subject']);
    Route::get('schedule', [DataController::class, 'subject']);
    Route::get('attendance', [DataController::class, 'subject']);
});