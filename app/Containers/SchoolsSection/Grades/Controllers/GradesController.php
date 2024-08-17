<?php

namespace App\Containers\SchoolsSection\Grades\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\SchoolsSection\Grades\Requests\StoreGradesRequest;
use App\Containers\SchoolsSection\Grades\Requests\UpdateGradesRequest;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\SchoolsSection\Grades\Actions\CreateGradesAction;
use App\Containers\SchoolsSection\Grades\Actions\UpdateGradesAction;
use App\Containers\SchoolsSection\Grades\Resources\GradesResource;
use App\Containers\SchoolsSection\Grades\Actions\GetSubjectGrade;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use App\Containers\SchoolsSection\Grades\Actions\CalculateOverallResultsAction;
use Illuminate\Http\JsonResponse;
use App\Containers\UsersSection\Students\Data\Models\Student;

class GradesController extends Controller
{
    public function index(Subject $subject)
    {
        $grades = Grade::join('subjects','subjects.id','=','grades.subject_id')
            ->join('students','students.id','=','grades.student_id')
            ->join('tutors','tutors.id','=','grades.tutor_id')
            ->where('subjects.id',$subject->id)
            ->select(
                'grades.score as score',
                'grades.total_marks as marks',
                'grades.grade_value as grade_value',
                'grades.comments as grade_comments',
                'grades.graded_at as graded_at',
                'grades.id as grade_id',
                'students.first_name as student_first_name',
                'students.last_name as student_last_name',
                'subjects.name as subject_name',
                'subjects.code as subject_code',
                'tutors.first_name as tutor_first_name',
                'tutors.last_name as tutor_last_name'
            )
            ->get();
        return response()->json(['grades'=>$grades],200);
    }
    public function store(StoreGradesRequest $request, Tutor $tutor, Subject $subject){
        $newGrade = app(CreateGradesAction::class)->run($request,$tutor, $subject);
        return response()->json(['message'=>'Grade uploaded successfully','grade'=>$newGrade],201);
    }
    public function show(Grade $grades){
        return response()->json(new GradesResource($grades),200);
    }
    public function update(UpdateGradesRequest $request, Grade $grades){
        $updateGrades = app(UpdateGradesAction::class)->run($request, $grades);
        return response()->json(['message'=>'Grade updated successfully','grade'=>$updateGrades],200);
    }
    public function destroy(Grade $grades){
        $grades->delete();
        return response()->json(['message'=>'Grade deleted successfully'],200);
    }

    public function getSubjectGrades(){
        $subjectGrade = app(GetSubjectGrade::class)->run();
        return response()->json(['grades'=>$subjectGrade],200);
    }
    public function getOverallResults(Student $student): JsonResponse
    {
        try {
            // Calculate overall results
            $results = app(CalculateOverallResultsAction::class)->run($student);

            // Return response as JSON
            return response()->json($results, 200);

        } catch (\Exception $e) {
            // Handle any exceptions that might occur
            return response()->json([
                'status' => 'Error',
                'message' => 'An error occurred while retrieving the results: ' . $e->getMessage()
            ], 500);
        }
    }
}
