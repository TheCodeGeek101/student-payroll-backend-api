<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Containers\UsersSection\Administrator\Controllers\AdminController;
use App\Containers\UsersSection\Students\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Containers\FinancialSection\Payments\Controllers\PaymentController;
use App\Containers\SchoolsSection\Subjects\Controllers\SubjectsController;
use App\Containers\UsersSection\Tutors\Controllers\TutorController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

 // All user routes
Route::controller(UserController::class)->name('user.')->prefix('users')->group(function () {
        Route::get('/', 'index');
        Route::get('/show/{user}', 'show');
        Route::post('/add', 'store');
        Route::put('/update/{user}', 'update');
});

 // All admin routes
Route::controller(AdminController::class)->name('admin.')->prefix('admin')->group(function() {
//    Route::get('/students/all', 'index');
});

 // All student routes
Route::controller(StudentController::class)->name('student.')->prefix('students')->group(function() {
    Route::get('/', 'index');
    Route::post('/create', 'store');
    Route::put('/update/{student}', 'update');
    Route::get('/show/{student}', 'show');
});

// All payment routes
Route::controller(PaymentController::class)->name('payment.')->prefix('payments')->group(function() {
    Route::get('/','index');
    Route::post('/create/{student}', 'payments');
});

//All Subject routes
Route::controller(SubjectsController::class)->name('subjects.')->prefix('subjects')->group(function() {
    Route::get('/', 'index');
    Route::post('/create', 'create')->name("create");
    Route::get('/show/{subject}', 'show')->name("show");
    Route::put('/update/{subject}', 'update')->name("update");
    Route::delete('/delete/{subject}', 'delete')->name("delete");
});

//All tutor routes
Route::prefix('tutors')->controller(TutorController::class)->name('tutor.')->group(function() {
    Route::get('/', 'index');
    Route::post('/create', 'store')->name("create");
    Route::get('/show/{tutor}', 'show')->name("show");
    Route::put('/update/{tutor}', 'update')->name("update");
    Route::delete('/delete/{tutor}', 'delete')->name("delete");
});

