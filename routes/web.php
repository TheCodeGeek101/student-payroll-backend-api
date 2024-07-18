<?php

use Illuminate\Support\Facades\Route;
use App\Containers\UsersSection\Tutors\Controllers\TutorController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//All tutor routes
Route::prefix('tutors')->controller(TutorController::class)->name('tutor.')->group(function() {
    Route::get('/', 'index');
    Route::post('/create', 'store')->name("create");
    Route::get('/show/{tutor}', 'show')->name("show");
    Route::put('/update/{tutor}', 'update')->name("update");
    Route::delete('/delete/{tutor}', 'delete')->name("delete");
});
