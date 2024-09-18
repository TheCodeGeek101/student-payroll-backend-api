<?php

use App\Containers\FinancialSection\Payments\Controllers\PaymentController;
use App\Containers\SchoolsSection\Grades\Controllers\GradesController;
use App\Containers\SchoolsSection\Subjects\Controllers\SubjectsController;
use App\Containers\UsersSection\Students\Controllers\StudentController;
use App\Containers\UsersSection\Tutors\Controllers\TutorController;
use App\Ship\Controllers\AuthenticationController;
use App\Ship\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Containers\SchoolsSection\Class\Controllers\ClassroomController;
use App\Containers\SchoolsSection\Department\Controllers\DepartmentController;
use App\Containers\SchoolsSection\Assessments\Controllers\AssessmentController;
use App\Containers\UsersSection\Admin\Controllers\AdminController;
use App\Containers\SchoolsSection\Term\Controllers\TermController;
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
Route::controller(UserController::class)
    ->name('user.')
    ->prefix('users')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/show/{user}', 'show');
        Route::post('/create', 'store');
        Route::put('/update/{user}', 'update');
    });

// All admin routes
Route::controller(AdminController::class)
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/show/{admin}', 'show');
        Route::post('/create', 'store');
        Route::put('/update/{admin}', 'update');
    });


// All student routes
Route::controller(StudentController::class)
    ->name('student.')
    ->prefix('students')
    ->group(function () {

        // CRUD ENDPOINTS
        Route::get('/', 'index');
        Route::post('/create', 'store');
        Route::put('/update/{student}', 'update');
        Route::get('/show/{student}', 'show');
        Route::delete('/delete/{student}', 'destroy');

        // ADDITIONAL ENDPOINTS
        Route::get('/{student}/class/subjects', 'getStudentClassSubjects')->name('class.subjects');  // Corrected
        Route::post('/{student}/subject/enroll', 'enrollSubject')->name('subject.enroll');
        Route::get('/{student}/subjects', 'getEnrolledSubjects')->name('subjects');
        Route::get('/{student}/term/{term}/class/{class}/subjects/grades', 'getStudentGrades')->name('subjects.grades');
        Route::get('/withdrawn', 'withdrawnStudents')->name('withdrawn');
        Route::post('/{student}/profile/picture', 'setProfilePicture')->name('picture');
    });


// All payment routes
Route::controller(PaymentController::class)
    ->name('payment.')
    ->prefix('payments')
    ->group(function () {
        Route::get('/student/{student}', 'index');
        Route::post('/create', 'store');
        Route::get('/show/{payment}', 'show');
        Route::post('/transactions', 'transactions')->name('transactions');
        Route::delete('/delete/{payment}', 'destroy');
        Route::post('/admin/{admin}', 'approvePayment')->name('approve');
    });


//All Subject routes
Route::controller(SubjectsController::class)
    ->name('subjects.')
    ->prefix('subjects')
    ->group(function () {

        // CRUD ENDPOINTS
        Route::get('/', 'index');
        Route::post('/create', 'create')->name("create");
        Route::get('/show/{subject}', 'show')->name("show");
        Route::put('/update/{subject}', 'update')->name("update");
        Route::delete('/delete/{subject}', 'delete')->name("delete");

        // ADDITIONAL ENDPOINTS
        Route::post('/{subject}/admin/{admin}/assign', 'assignSubjectToTutor')
            ->name("tutor.assign");
        Route::post('/class', 'getSubjectByClass')
            ->name("class");
        Route::get('/tutors', 'getSubjectTutors')
            ->name('tutors');
    });

//All tutor routes
Route::prefix('tutors')
    ->controller(TutorController::class)
    ->name('tutor.')
    ->group(function () {

        // CRUD ENDPOINTS
        Route::get('/', 'index');
        Route::post('/admin/create', 'createAdmin');
        Route::post('/create', 'store')
            ->name("create");
        Route::get('/show/{tutor}', 'show')
            ->name("show");
        Route::put('/update/{tutor}', 'update')
            ->name("update");
        Route::delete('/delete/{tutor}', 'delete')->name("delete");


        // ADDITIONAL ENDPOINTS
        Route::post('/{tutor}/student/add', 'addStudentsToClass')->name("student.add");
        Route::get('/{tutor}/subjects', 'getTutorSubjects')->name("subjects");
        Route::get('/{tutor}/subject/{subject}/students', 'getEnrolledStudents')->name("students");
        Route::get('/{tutor}/students/grades', 'getStudentGrades')->name('grades');
        Route::get('/subject/{subject}/department', 'getTutorsUnderDepartment')->name('department');
    });

//All Assessment routes
Route::prefix('assessments')
    ->controller(AssessmentController::class)
    ->name('assessments')
    ->group(function () {
        //   CRUD ROUTES
        Route::get('/subject/{subject}/term/{term}', 'index');
        Route::get('/show/{assessment}', 'show');
        Route::put('/assessment/{assessment}/update', 'update')->name("update");
        Route::post('/tutor/{tutor}/subject/{subject}/create', 'store');
        Route::delete('/delete/{assessment}', 'destroy')->name("delete");

        //    ADDITIONAL ROUTES
        Route::get('/student/{student}/subjects/results', 'getStudentAssessment');
    });

//All Grade routes
Route::prefix('grades')
    ->controller(GradesController::class)
    ->name('grades.')
    ->group(function () {

        // CRUD ENDPOINTS
        Route::get('/subject/{subject}/term/{term}', 'index');
        Route::post('/tutor/{tutor}/subject/{subject}/create', 'store')->name("create");
        Route::get('/show/{grade}', 'show')->name("show");
        Route::put('/grade/{grade}/update', 'update')->name("update");
        Route::delete('/delete/{grade}', 'delete')->name("delete");

        // ADDITIONAL ENDPOINTS
        Route::get('/subjects/', 'getSubjectGrades')->name("subjects");
        Route::get('/student/{student}/class/{class}/results', 'getOverallResults');
    });

// All Classes routes
Route::prefix('classroom')
    ->controller(ClassroomController::class)
    ->name('classroom.')
    ->group(function () {
        // CRUD ENDPOINTS
        Route::get('/', 'index');
        Route::post('/tutor/{tutor}/create', 'store')->name("create");
        Route::get('/show/{classroom}', 'show')->name("show");
        Route::put('/update/{classroom}', 'update')->name("update");
        Route::delete('/delete/{classroom}', 'delete')->name("delete");
    });

Route::prefix('department')
    ->controller(DepartmentController::class)
    ->name('department.')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/create', 'store')->name("create");
        Route::get('/show/{department}', 'show')->name("show");
        Route::put('/update/{department}', 'update')->name("update");
        Route::delete('/delete/{department}', 'delete')->name("delete");
    });

Route::controller(TermController::class)
    ->prefix('terms')
    ->name('terms.')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/create', 'store')->name("create");
        Route::get('/show/{term}', 'show')->name("show");
        Route::put('/update/{term}', 'update')->name("update");
        Route::delete('/delete/{term}', 'delete')->name("delete");
    });
