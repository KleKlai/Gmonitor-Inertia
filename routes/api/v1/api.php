<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\LoginController;
use App\Http\Controllers\api\v1\JoinController;
use App\Http\Controllers\api\v1\SearchController;
use App\Http\Controllers\api\v1\ClassroomController;
use App\Http\Controllers\api\v1\AttendanceController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Users Route
Route::prefix('/user')->group( function() {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('/join', [JoinController::class, 'joinClassroom']);
    Route::get('/search', [SearchController::class, 'searchClassroom']);
    Route::get('/classroom-list', [ClassroomController::class, 'index']);
    Route::post('/attendance', [AttendanceController::class, 'recordAttendance']);
});


