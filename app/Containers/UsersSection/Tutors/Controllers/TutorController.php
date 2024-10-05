<?php
// app/Containers/UsersSection/Tutors/Controllers/TutorController.php

namespace App\Containers\UsersSection\Tutors\Controllers;

use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use App\Http\Controllers\Controller;
use App\Containers\UsersSection\Tutors\Actions\CreateTutorAction;
use App\Containers\UsersSection\Tutors\Actions\UpdateTutorAction;
use App\Containers\UsersSection\Tutors\Requests\StoreTutorRequest;
use App\Containers\UsersSection\Tutors\Requests\UpdateTutorRequest;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\UsersSection\Tutors\Resources\TutorResource;
use App\Containers\UsersSection\Tutors\Actions\GetTutorsUnderDepartmentAction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Containers\UsersSection\Tutors\Actions\GetStudentGradesAction;
use App\Containers\UsersSection\Tutors\Actions\AddStudentToClassAction;
use App\Containers\UsersSection\Tutors\Actions\GetEnrolledStudentsAction;
use App\Containers\UsersSection\Tutors\Actions\GetTutorSubjectsAction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Containers\UsersSection\Admin\Requests\StoreAdminRequest;
use App\Containers\UsersSection\Admin\Data\Models\Adminstrator;
use App\Jobs\SendEmailJob;
use League\Config\Exception\ValidationException;

class TutorController extends Controller
{
    protected $createTutorAction;

    public function index(): JsonResponse
    {
        $tutors = Tutor::join('departments', 'departments.id', '=', 'tutors.department_id')
            ->select('tutors.*', 'departments.name as department_name')
            ->get();
        return response()->json(['tutors' => $tutors], 200);
    }

    public function __construct(CreateTutorAction $createTutorAction)
    {
        $this->createTutorAction = $createTutorAction;
    }

    public function createAdmin(StoreAdminRequest $request): JsonResponse
    {
        // Handle validation exception if it occurs
        try {
            $adminstrator = null;
            $user = null;
            $password = 'SecuredKey@2024';
            DB::transaction(function () use ($request, &$user, &$adminstrator) {
                $user = User::create([
                    'name' => $request->validated()['full_name'],
                    'email' => $request->validated()['email'],
                    'password' => Hash::make('SecuredKey@2024'),
                    'role' => 'admin'
                ]);

                $adminstrator = Adminstrator::create(
                    array_merge($request->validated(),
                        ['user_id' => $user->id, 'registered_by' => 1]
                    ));
            });
            SendEmailJob::dispatch($user, $password)->delay(now()->addMinutes(1));

            return response()->json([
                'message' => 'Admin created successfully',
                'admin' => $adminstrator
            ], 201);

        } catch (ValidationException $e) {
            // Return a 422 status code with validation errors if validation fails
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Handle other exceptions if needed
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function store(StoreTutorRequest $request): JsonResponse
    {
        try {
            $tutor = $this->createTutorAction->run($request);
            return response()->json(['tutor' => $tutor], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function show(Tutor $tutor): JsonResponse
    {
        $showTutor = Tutor::join('departments', 'departments.id', '=', 'tutors.department_id')
            ->where('tutors.id', $tutor->id)
            ->select('tutors.*', 'departments.name as department_name')
            ->first();

        return response()->json($showTutor, 200);
    }


    public function update(UpdateTutorRequest $request, Tutor $tutor): JsonResponse
    {
        $updatedTutor = app(UpdateTutorAction::class)->run($request, $tutor);
        return response()->json(['message' => 'Tutor updated successfully', 'Tutor' => $updatedTutor], 200);
    }

    public function getTutorsUnderDepartment(Subject $subject): JsonResponse
    {
        $tutors = app(GetTutorsUnderDepartmentAction::class)->run($subject);
        return response()->json(['tutors' => $tutors], 200);
    }

    public function addStudentsToClass(Request $request, Tutor $tutor): JsonResponse
    {
        app(AddStudentToClassAction::class)->run($request, $tutor);
        return response()->json(['message' => 'Student added to class successfully'], 200);
    }

    public function getTutorSubjects(Tutor $tutor): JsonResponse
    {
        $subjects = app(GetTutorSubjectsAction::class)->run($tutor);
        return response()->json(['subjects' => $subjects], 200);
    }

    public function getEnrolledStudents(Tutor $tutor, Subject $subject): JsonResponse
    {
        $enrolledStudents = app(GetEnrolledStudentsAction::class)->run($tutor, $subject);
        return response()->json(['students' => $enrolledStudents], 200);
    }

    public function getStudentGrades(Tutor $tutor): JsonResponse
    {
        $grades = app(GetStudentGradesAction::class)->run($tutor);
        return response()->json(['grades' => $grades], 200);
    }

    public function destroy(Tutor $tutor): JsonResponse
    {
        $tutor->delete();
        return response()->json(['message' => 'Tutor deleted successfully'], 200);
    }
}
