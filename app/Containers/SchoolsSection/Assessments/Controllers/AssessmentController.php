<?php
namespace App\Containers\SchoolsSection\Assessments\Controllers;

use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;
use App\Containers\SchoolsSection\Assessments\Requests\StoreAssessmentRequest;
use App\Containers\SchoolsSection\Assessments\Requests\UpdateAssessmentRequest;
use App\Containers\SchoolsSection\Assessments\Actions\CreateAssessmentAction;
use App\Containers\SchoolsSection\Assessments\Actions\UpdateAssessmentAction;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Containers\SchoolsSection\Assessments\Actions\GetStudentAssessmentAction;
use App\Containers\SchoolsSection\Assessments\Exception\GradeAlreadyExistsException;
use App\Containers\SchoolsSection\Assessments\Actions\GetAllAssessmentsAction;
use App\Containers\SchoolsSection\Assessments\Actions\GetSingleAssessmentAction;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index(Subject $subject,Term $term): JsonResponse
    {
        $assessments = app(GetAllAssessmentsAction::class)->run($subject,$term);
        return response()->json([
            'message' => 'assessments retrieved successfully',
            'assessments'=>$assessments
        ],200);
    }

    public function store(StoreAssessmentRequest $request, Tutor $tutor, Subject $subject): JsonResponse
    {
        try {
            // Call the action to create the assessment
            $newAssessment = app(CreateAssessmentAction::class)->run($request, $tutor, $subject);

            // Return a successful response with the newly created assessment
            return response()->json(['assessment' => $newAssessment], 201);
        } catch (GradeAlreadyExistsException $e) {
            // If the grade already exists, catch the exception and return the conflict response
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
    public function show(Assessment $assessment): JsonResponse
    {
       $singleAssessment = app(GetSingleAssessmentAction::class)->run($assessment);
        return response()->json([
            'message'=>'assessments retrieved successfully',
            'assessment' => $singleAssessment
        ], 200);
    }

    public function update(UpdateAssessmentRequest $request, Assessment $assessment): JsonResponse
    {
        $updateAssessment = app(UpdateAssessmentAction::class)->run($request, $assessment);
        return response()->json(['assessment' => $updateAssessment], 200);
    }


    public function getStudentAssessment(Request $request,Student $student): JsonResponse
    {
        $assessments = app(GetStudentAssessmentAction::class)->run($request,$student);
        return response()->json(['assessments'=> $assessments],200);
    }

    public function delete(Assessment $assessment): JsonResponse
    {
        $assessment->delete();
        return response()->json(['message' => 'Assessment deleted successfully'], 204);
    }

}
