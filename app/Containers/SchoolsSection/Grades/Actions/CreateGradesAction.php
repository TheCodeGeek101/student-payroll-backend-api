<?php
namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\SchoolsSection\Grades\Requests\StoreGradesRequest;
use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;
use Illuminate\Support\Facades\DB;
use App\Ship\Actions\Action;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use App\Containers\SchoolsSection\Grades\Actions\MapPointsToLetterAction;
use App\Containers\SchoolsSection\Grades\Actions\DisplayFinalGradeComments;
class CreateGradesAction extends Action
{
    public function run(StoreGradesRequest $request, Tutor $tutor, Subject $subject)
    {
        $grades = null;

        DB::transaction(function () use ($request, &$grades, $tutor, $subject) {
            $studentId = $request->validated()['student_id'];
            $score = $request->validated()['score'];
            $totalMarks = $request->validated()['total_marks'];
            $endOfTermResult = $score / $totalMarks;

            // Retrieve assessments for the given student and subject
            $assessments = Assessment::where('student_id', $studentId)
                ->where('subject_id', $subject->id)
                ->get();

            // Calculate the total score from the assessments
            $totalAssessmentScore = $assessments->sum('grade_value'); // Sum of pre-calculated weighted scores
            $assessmentCount = $assessments->count();

            // If there are no assessments, default to 0
            $weightedAssessmentScore = $assessmentCount > 0 ? ($totalAssessmentScore / $assessmentCount) : 0;

            // Calculate the final weighted assessment score (40% weight)
            $weightedAssessmentScore = $weightedAssessmentScore * 40;

            // Calculate the final weighted end-of-term result (60% weight)
            $weightedEndOfTermResult = $endOfTermResult * 60;

            // Calculate the final grade value
            $finalGradeValue = $weightedAssessmentScore + $weightedEndOfTermResult;

            // Map the final grade value to a letter grade
            $letterGrade = app(MapPointsToLetterAction::class)->run($finalGradeValue);
            $comments = app(DisplayFinalGradeComments::class)->run($letterGrade);
            // Create or update the grade record
            $grades = Grade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $subject->id,
                    'tutor_id' => $tutor->id,
                ],
                [
                    'score' => $score,
                    'total_marks' => $totalMarks,
                    'grade' => $letterGrade,
                    'grade_value' => $finalGradeValue,
                    'comments' => $comments,
                    'graded_at' => $request->validated()['graded_at']
                ]
            );
        });

        return $grades;
    }
}
