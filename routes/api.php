<?php

use App\Containers\FinancialSection\Payments\Controllers\PaymentController;
use App\Containers\SchoolsSection\Grades\Controllers\GradesController;
use App\Containers\SchoolsSection\Subjects\Controllers\SubjectsController;
use App\Containers\UsersSection\Adminstrator\Controllers\AdminController;
use App\Containers\UsersSection\Students\Controllers\StudentController;
use App\Containers\UsersSection\Tutors\Controllers\TutorController;
use App\Ship\Controllers\AuthenticationController;
use App\Ship\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    //Authentication routes
Route::prefix('auth')->controller(AuthenticationController::class)->group(function () {
    Route::post('/login', 'login');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

 // All user routes
Route::controller(UserController::class)->name('user.')->prefix('users')->group(function () {
        Route::get('/', 'index');
        Route::get('/show/{user}', 'show');
        Route::post('/create', 'store');
        Route::put('/update/{user}', 'update');
});

 // All admin routes
Route::controller(AdminController::class)->name('admin.')->prefix('admin')->group(function() {
            //CRUD ENDPOINTS
            Route::get('/','index')->name('index');
            Route::get('/show/{admin}', 'show');
            Route::post('/create', 'store');
            Route::put('/update/{admin}', 'update');
            Route::delete('/delete/{admin}', 'destroy');
});

 // All student routes
Route::controller(StudentController::class)->name('student.')->prefix('students')->group(function() {

    // CRUD ENDPOINTS
    Route::get('/', 'index');
    Route::post('/create', 'store');
    Route::put('/update/{student}', 'update');
    Route::get('/show/{student}', 'show');
    Route::delete('/delete/{student}', 'destroy');

    // ADDITIONAL ENDPOINTS
    Route::post('/{student}/subject/enroll','enrollSubject')->name('subject.enroll');
    Route::get('/{student}/subjects', 'getEnrolledSubjects')->name('subjects');

});

// All payment routes
Route::controller(PaymentController::class)->name('payment.')->prefix('payments')->group(function() {
    Route::get('/','index');
    Route::post('/create/{student}', 'payments');
});


//All Subject routes
Route::controller(SubjectsController::class)->name('subjects.')->prefix('subjects')->group(function() {

        // CRUD ENDPOINTS
    Route::get('/', 'index');
    Route::post('/create', 'create')->name("create");
    Route::get('/show/{subject}', 'show')->name("show");
    Route::put('/update/{subject}', 'update')->name("update");
    Route::delete('/delete/{subject}', 'delete')->name("delete");

        // ADDITIONAL ENDPOINTS
    Route::post('/{admin}/assign','assignSubjectToTutor')->name("tutor");
    Route::post('/class', 'getSubjectByClass')->name("class");

});

//All tutor routes
Route::prefix('tutors')->controller(TutorController::class)->name('tutor.')->group(function() {

    //CRUD ENDPOINTS
    Route::get('/', 'index');
    Route::post('/create', 'store')->name("create");
    Route::get('/show/{tutor}', 'show')->name("show");
    Route::put('/update/{tutor}', 'update')->name("update");
    Route::delete('/delete/{tutor}', 'delete')->name("delete");


    //ADDITIONAL ENDPOINTS
    Route::get('/{tutor}/subjects','getTutorSubjects')->name("subjects");
    Route::get('/{tutor}/students','getEnrolledStudents')->name("students");
    Route::get('{tutor}/students/grades', 'getStudentGrades')->name('grades');

});

//All Grade routes
Route::prefix('grades')->controller(GradesController::class)->name('grades.')->group(function() {
       // CRUD ENDPOINTS
    Route::get('/', 'index');
    Route::post('/{tutor}/create', 'store')->name("create");
    Route::get('/show/{grade}', 'show')->name("show");
    Route::put('/update/{grade}', 'update')->name("update");
    Route::delete('/delete/{grade}', 'delete')->name("delete");

      // ADDITIONAL ENDPOINTS
    Route::get('/subjects/', 'getSubjectGrades')->name("subjects");
});

