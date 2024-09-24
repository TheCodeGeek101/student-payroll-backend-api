<?php

namespace App\Containers\UsersSection\Students\Controllers;

use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Containers\UsersSection\Students\Actions\UpdateStudentAction;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\UsersSection\Students\Requests\UpdateStudentRequest;
use App\Http\Controllers\Controller;
use App\Containers\UsersSection\Students\Actions\CreateStudentAction;
use App\Containers\UsersSection\Students\Requests\StoreStudentRequest;
use App\Containers\UsersSection\Students\Resources\StudentResource;
use App\Containers\UsersSection\Students\Actions\EnrollSubjectAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Containers\UsersSection\Students\Actions\GetEnrolledSubjectAction;
use App\Containers\UsersSection\Students\Actions\GetStudentGradesAction;
use App\Containers\UsersSection\Students\Actions\GetStudentClassSubjectAction;
use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;
use App\Containers\UsersSection\Students\Actions\WithdrawnStudentsAction;
use App\Containers\UsersSection\Students\UploadProfilePictureAction;
use App\Containers\UsersSection\Students\Actions\CanStudentRegisterAction;

class StudentController extends Controller
{
    public function index(): JsonResponse
    {
        $students = Student::all();
        return response()->json(['students' => $students]);
    }

    public function store(StoreStudentRequest $request): JsonResponse
    {
        $student = app(CreateStudentAction::class)->run($request);
        return response()->json([
            'message' => 'Student Created Successfully',
            'student' => $student
        ], 201);
    }

    public function show(Student $student)
    {
        return response()->json(new StudentResource($student), 200);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $updatedStudent = app(UpdateStudentAction::class)->run($request, $student);
        return response()->json([
            'message' => 'Student Updated Successfully',
            'student' => $updatedStudent
        ], 200);
    }

    public function getStudentClassSubjects(Student $student): JsonResponse
    {
        $subjects = app(GetStudentClassSubjectAction::class)->run($student);

        return response()->json([
            'subjects' => $subjects
        ], 200);
    }

    public function enrollSubject(Request $request, Student $student): JsonResponse
    {
        try {

            $result = app(EnrollSubjectAction::class)->run($request, $student);

            if ($result === false) {
                return response()->json([
                    'message' => 'Student already enrolled in this subject'
                ], 409);
            }

            return response()->json([
                'message' => 'Student enrolled in subject successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during enrollment'
            ], 500);
        }
    }

    public function getEnrolledSubjects(Student $student): JsonResponse
    {
        $enrolledSubjects = app(GetEnrolledSubjectAction::class)->run($student);
        return response()->json([
            'subjects' => $enrolledSubjects
        ], 200);
    }

    public function getStudentGrades(Request $request,Student $student, Term $term): JsonResponse
    {
        try {
            // Get the student grades from the action
            $studentGrades = app(GetStudentGradesAction::class)
                ->run($request, $student, $term);

            // Check if the result is an array and is empty
            if (is_array($studentGrades) && empty($studentGrades['grades'])) {
                return response()->json([
                    'message' => 'No grades found for this student and term',
                ], 404);
            }

            return response()->json($studentGrades, 200);
        } catch (\Exception $e) {
            // Optional: Log the error for future debugging
            // Log::error('Error retrieving grades: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'An error occurred while retrieving grades',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Student $student): JsonResponse
    {
        $student->delete();
        return response()->json([
            'message' => 'Student deleted successfully'
        ], 200);
    }

    public function withdrawnStudents(): JsonResponse
    {
        $students = app(WithdrawnStudentsAction::class)->run();
        return response()->json([
            'students' => $students
        ], 200);
    }

    public function setProfilePicture(Request $request, Student $student): JsonResponse
    {
        app(UploadProfilePictureAction::class)->run($request, $student);
        return response()->json([
            'message' => 'Picture updated successfully'
        ], 200);
    }

    public function canStudentRegister(Request $request, Student $student): JsonResponse
    {
        $isStudentEligibleForRegistration = app(CanStudentRegisterAction::class)->run($request, $student);
        return response()->json([
            'decision' => $isStudentEligibleForRegistration
        ], 200);
    }
}
