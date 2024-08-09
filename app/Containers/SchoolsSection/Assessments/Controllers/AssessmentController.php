<?php
namespace App\Containers\SchoolsSection\Assessments\Controllers;

use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;
use App\Containers\SchoolsSection\Assessments\Requests\StoreAssessmentRequest;
use App\Containers\SchoolsSection\Assessments\Requests\UpdateAssessmentRequest;
use App\Containers\SchoolsSection\Assessments\Actions\CreateAssessmentAction;
use App\Containers\SchoolsSection\Assessments\Actions\UpdateAssessmentAction;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class AssessmentController extends Controller
{
    public function index(Subject $subject): JsonResponse
    {
        $assessments = Assessment::join('subjects','subjects.id','=','assessments.subject_id')
            ->join('students','students.id','=','assessments.student_id')
            ->join('tutors','tutors.id','=','assessments.tutor_id')
            ->where('subjects.id',$subject->id)
            ->select(
                'assessments.id as assessment_id',
                'assessments.score as assessment_score',
                'assessments.total_marks as assessment_marks',
                'assessments.grade_value as assessment_grade_value',
                'assessments.comments as assessment_comments',
                'assessments.date as assessment_date',
                'students.first_name as student_first_name',
                'students.last_name as student_last_name',
                'subjects.name as subject_name',
                'subjects.code as subject_code',
                'tutors.first_name as tutor_first_name',
                'tutors.last_name as tutor_last_name',
            )->get();
        return response()->json(['assessments' => $assessments], 200);
    }

    public function store(StoreAssessmentRequest $request, Tutor $tutor, Subject $subject): JsonResponse
    {
        $newAssessment = app(CreateAssessmentAction::class)->run($request, $tutor, $subject);
        return response()->json(['assessment' => $newAssessment], 201);
    }

    public function show(Assessment $assessment): JsonResponse
    {
        return response()->json(['assessment' => $assessment], 200);
    }

    public function update(UpdateAssessmentRequest $request, Assessment $assessment): JsonResponse
    {
        $updateAssessment = app(UpdateAssessmentAction::class)->run($request, $assessment);
        return response()->json(['assessment' => $updateAssessment], 200);
    }

    public function delete(Assessment $assessment): JsonResponse
    {
        $assessment->delete();
        return response()->json(['message' => 'Assessment deleted successfully'], 204);
    }
}
