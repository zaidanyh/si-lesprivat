<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('teacher/login', [TeacherController::class, 'login']);
Route::post('student/login', [StudentController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    //
});