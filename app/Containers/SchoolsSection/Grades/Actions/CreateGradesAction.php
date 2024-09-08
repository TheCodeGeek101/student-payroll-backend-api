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
use Illuminate\Support\Facades\Log;

class CreateGradesAction extends Action
{
    public function run(StoreGradesRequest $request, Tutor $tutor, Subject $subject)
    {
        $studentId = $request->validated()['student_id'];
        $termId = $request->validated()['term_id'];

        Log::info('CreateGradesAction called', [
            'student_id' => $studentId,
            'subject_id' => $subject->id,
            'term_id' => $termId,
        ]);

        // Check if a final grade already exists for the student, subject, and term
        $existingGrade = Grade::where('student_id', $studentId)
            ->where('subject_id', $subject->id)
            ->where('term_id', $termId)
            ->first();

        if ($existingGrade) {
            Log::warning('Final grade already exists for this student, subject, and term.');
            return false;
        }

        $grades = null;

        DB::transaction(function () use ($request, &$grades, $tutor, $subject) {
            try {
                Log::info('Starting database transaction for grade creation');

                $studentId = $request->validated()['student_id'];
                $termId = $request->validated()['term_id'];
                $classId = $request->validated()['class_id'];
                $score = $request->validated()['score'];
                $totalMarks = $request->validated()['total_marks'];
                $endOfTermResult = $score / $totalMarks;

                // Flag to determine whether to include assessments in the final grade
                $includeAssessments = $request->validated()['include_assessments'] ?? true;

                $totalAssessmentScore = 0;
                $assessmentCount = 0;

                if ($includeAssessments) {
                    // Retrieve assessments for the given student and subject
                    $assessments = Assessment::where('student_id', $studentId)
                        ->where('subject_id', $subject->id)
                        ->get();

                    $totalAssessmentScore = $assessments->sum('grade_value');
                    $assessmentCount = $assessments->count();

                    if ($assessmentCount > 0) {
                        $averageAssessmentScore = $totalAssessmentScore / $assessmentCount;
                        // Option to exclude assessments if performance is below a threshold, e.g., 50%
                        if ($averageAssessmentScore < 0.5) {
                            $includeAssessments = false;
                        }
                    }
                }

                // Calculate weighted scores
                $weightedAssessmentScore = $includeAssessments && $assessmentCount > 0
                    ? ($totalAssessmentScore / $assessmentCount) * 40
                    : 0;

                $weightedEndOfTermResult = $endOfTermResult * 60;

                // Final grade calculation
                $finalGradeValue = $weightedAssessmentScore + $weightedEndOfTermResult;

                $letterGrade = app(MapPointsToLetterAction::class)->run($finalGradeValue, $classId);
                $comments = app(DisplayFinalGradeComments::class)->run($letterGrade);

                Log::info('Calculated final grade value and comments', [
                    'final_grade_value' => $finalGradeValue,
                    'letter_grade' => $letterGrade,
                    'comments' => $comments,
                ]);

                $grades = Grade::create([
                    'student_id' => $studentId,
                    'subject_id' => $subject->id,
                    'tutor_id' => $tutor->id,
                    'term_id' => $termId,
                    'class_id' => $classId,
                    'score' => $score,
                    'total_marks' => $totalMarks,
                    'grade' => $letterGrade,
                    'grade_value' => $finalGradeValue,
                    'comments' => $comments,
                    'graded_at' => $request->validated()['graded_at'],
                ]);

                Log::info('Grade record created successfully', ['grade' => $grades]);
            } catch (\Exception $e) {
                Log::error('Error in transaction', [
                    'message' => $e->getMessage(),
                    'stack' => $e->getTraceAsString(),
                ]);
                throw $e;
            }
        });

        return $grades;
    }
}
