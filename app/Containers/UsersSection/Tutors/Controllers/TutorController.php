<?php


namespace App\Containers\UsersSection\Tutors\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\UsersSection\Tutors\Actions\{
    CreateTutorAction,
    UpdateTutorAction,
    GetTutorSubjectsAction,
    GetEnrolledStudentsAction,
    GetStudentGradesAction,
    AddStudentToClassAction
};
use App\Containers\UsersSection\Tutors\Requests\{
    StoreTutorRequest,
    UpdateTutorRequest
};
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\UsersSection\Tutors\Resources\TutorResource;
use Illuminate\Http\{JsonResponse, Request};

class TutorController extends Controller
{
    public function index(): JsonResponse
    {
        $tutors = Tutor::all();
        return response()->json(['Tutors' => $tutors], 200);
    }

    public function store(StoreTutorRequest $request): JsonResponse
    {
        $newTutor = app(CreateTutorAction::class)->run($request);
        return response()->json(['message' => 'Tutor created successfully', 'Tutor' => $newTutor], 201);
    }

    public function show(Tutor $tutor): JsonResponse
    {
        return response()->json(new TutorResource($tutor), 200);
    }

    public function update(UpdateTutorRequest $request, Tutor $tutor): JsonResponse
    {
        $updatedTutor = app(UpdateTutorAction::class)->run($request, $tutor);
        return response()->json(['message' => 'Tutor updated successfully', 'Tutor' => $updatedTutor], 200);
    }

    public function destroy(Tutor $tutor): JsonResponse
    {
        $tutor->delete();
        return response()->json(['message' => 'Tutor deleted successfully'], 200);
    }

    public function addStudentsToClass(Request $request, Tutor $tutor): JsonResponse
    {
        app(AddStudentToClassAction::class)->run($request, $tutor);
        return response()->json(['message' => 'Student added to class successfully'], 200);
    }

    public function getTutorSubjects(Tutor $tutor): JsonResponse
    {
        $subjects = app(GetTutorSubjectsAction::class)->run($tutor);
        return response()->json(['TutorSubjects' => $subjects], 200);
    }

    public function getEnrolledStudents(Tutor $tutor): JsonResponse
    {
        $enrolledStudents = app(GetEnrolledStudentsAction::class)->run($tutor);
        return response()->json(['data' => $enrolledStudents], 200);
    }

    public function getStudentGrades(Tutor $tutor): JsonResponse
    {
        $grades = app(GetStudentGradesAction::class)->run($tutor);
        return response()->json(['grades' => $grades], 200);
    }
}
