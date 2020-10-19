<?php

use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\StudentController;
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

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::prefix('teacher/{teacher}')->group(function () {
        Route::get('/', [TeacherController::class, 'show']);
        Route::put('/', [TeacherController::class, 'update']);
        Route::get('/schedule', [TeacherController::class, 'schedule']);
        Route::get('/schedule/{schedule}/detail', [TeacherController::class, 'schedule_detail']);
        Route::post('/schedule/{schedule}/attendance', [TeacherController::class, 'schedule_attendance']);
    });
    
    Route::prefix('student/{student}')->group(function () {
        Route::get('/', [StudentController::class, 'show']);
        Route::put('/', [StudentController::class, 'update']);
        Route::get('/schedule', [StudentController::class, 'schedule']);
        Route::get('/schedule/{schedule}/detail', [StudentController::class, 'schedule_detail']);
    });
});