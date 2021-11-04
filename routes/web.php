<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\QuestionController;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::redirect('/', 'login');

Route::get('/dashboard', [ClassroomController::class, 'index'])->name('dashboard');
Route::get('/profile/update', [PasswordController::class, 'index'])->name('profile.password');
Route::post('/profile/update', [PasswordController::class, 'store'])->name('profile.password.update');
Route::resource('/classroom', ClassroomController::class);
Route::get('/archive/classroom', [ClassroomController::class, 'archiveClassroomIndex'])->name('archive-classroom-index');
Route::get('/archive/classroom/{classroom}', [ClassroomController::class, 'archiveClassroom'])->name('archive-classroom');
Route::get('/archive/classroom/{classroom}/unarchive', [ClassroomController::class, 'unarchiveClassroom'])->name('unarchive-classroom');
Route::get('/classroom/remove-student/{classroom}/{user}', [ClassroomController::class, 'removeStudent'])->name('unenroll.student');
Route::get('/open-attendance/{classroom}', [AttendanceController::class, 'attendance'])->name('open.attendance');
Route::post('/question/ask/{classroom}', [QuestionController::class, 'store'])->name('ask.question');

require __DIR__.'/auth.php';
