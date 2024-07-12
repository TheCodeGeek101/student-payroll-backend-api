<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Containers\UsersSection\Administrator\Controllers\AdminController;
use App\Containers\UsersSection\Students\Controllers\StudentController;
use App\Http\Controllers\UserController;

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
    Route::post('/add', 'store');
    Route::put('/update/{student}', 'update');
    Route::get('/show/{student}', 'show');
});


