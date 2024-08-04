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
use Illuminate\Http\JsonResponse;
use App\Containers\UsersSection\Tutors\Actions\GetStudentGradesAction;
use App\Containers\UsersSection\Tutors\Actions\AddStudentToClassAction;
use App\Containers\UsersSection\Tutors\Actions\GetEnrolledStudentsAction;
use App\Containers\UsersSection\Tutors\Actions\GetTutorSubjectsAction;
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
