<?php

namespace App\Containers\UsersSection\Students\Controllers;

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
class StudentController extends Controller
{
    public function index() {
        $students = Student::all();
        return response()->json(['students'=>$students]);
    }

    public function store(StoreStudentRequest $request){
        $student = app(CreateStudentAction::class)->run($request);
        return response()->json([
            'message' => 'Student Created Successfully',
            'student' => $student
        ], 201);
    }

    public function show(Student $student){
        return response()->json(new StudentResource($student),200);
    }

    public function update(UpdateStudentRequest $request, Student $student){
        $updatedStudent = app(UpdateStudentAction::class)->run($request,$student);
        return response()->json([
            'message' => 'Student Updated Successfully',
            'student' => $updatedStudent
        ],200);
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
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
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
            'enrolledSubjects'=>$enrolledSubjects
        ],200);
    }

    public function getStudentGrades(Student $student): JsonResponse
    {
        try {
            $studentGrades = app(GetStudentGradesAction::class)->run($student);
            return response()->json([
                'message' => 'Grades retrieved successfully',
                'Grades' => $studentGrades
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving grades',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Student $student){
        $student->delete();
        return response()->json([
            'message'=>'Student deleted successfully'
        ],200);
    }
}
