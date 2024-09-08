<?php

namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\SchoolsSection\Grades\Requests\UpdateGradesRequest;
use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;
use Illuminate\Support\Facades\Log;
use App\Containers\SchoolsSection\Grades\Actions\MapPointsToLetterAction;
use App\Containers\SchoolsSection\Grades\Actions\DisplayFinalGradeComments;

class UpdateGradesAction extends Action
{
    public function run(UpdateGradesRequest $request, Grade $grade)
    {
        Log::info('UpdateGradesAction called', [
            'grade_id' => $grade->id,
            'student_id' => $grade->student_id,
            'subject_id' => $grade->subject_id,
        ]);

        // Retrieve updated data
        $score = $request->validated()['score'];
        $totalMarks = $request->validated()['total_marks'];
        $endOfTermResult = $score / $totalMarks; // Calculate the raw score percentage

        // Flag to determine whether to include assessments in the updated grade
        $includeAssessments = $request->validated()['include_assessments'] ?? true;

        $finalGradeValue = 0;
        $totalAssessmentScore = 0;
        $assessmentCount = 0;

        if ($includeAssessments) {
            // Retrieve assessments for the student and subject
            $assessments = Assessment::where('student_id', $grade->student_id)
                ->where('subject_id', $grade->subject_id)
                ->get();

            $totalAssessmentScore = $assessments->sum('grade_value');
            $assessmentCount = $assessments->count();

            if ($assessmentCount > 0) {
                $averageAssessmentScore = $totalAssessmentScore / $assessmentCount;

                // Calculate weighted assessment score (40%) and exam score (60%)
                $weightedAssessmentScore = ($totalAssessmentScore / $assessmentCount) * 0.40;
                $weightedEndOfTermResult = $endOfTermResult * 0.60;

                $finalGradeValue = ($weightedAssessmentScore + $weightedEndOfTermResult) * 100;
            } else {
                // If no assessments are found, treat it like excluding assessments
                $finalGradeValue = $endOfTermResult * 100;
            }
        }

        // If assessments are excluded or no assessments exist, set the final grade value to the score directly
        if (!$includeAssessments || $assessmentCount == 0) {
            $finalGradeValue = $endOfTermResult * 100;
        }

        // Map final grade value to a letter grade and add comments
        $letterGrade = app(MapPointsToLetterAction::class)->run($finalGradeValue);
        $comments = app(DisplayFinalGradeComments::class)->run($letterGrade);

        Log::info('Updated grade value and comments', [
            'final_grade_value' => $finalGradeValue,
            'letter_grade' => $letterGrade,
            'comments' => $comments,
        ]);

        // Update the grade with the new calculated values
        $updateGrade = $grade->update([
            'score' => $score,
            'total_marks' => $totalMarks,
            'grade_value' => $finalGradeValue,
            'grade' => $letterGrade,
            'comments' => $comments,
            'graded_at' => $request->validated()['graded_at'],
        ]);

        Log::info('Grade updated successfully', ['grade_id' => $grade->id]);

        return $updateGrade;
    }
}
