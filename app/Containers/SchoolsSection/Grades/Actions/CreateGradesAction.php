<?php


namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\SchoolsSection\Grades\Requests\StoreGradesRequest;
use Illuminate\Support\Facades\DB;
use App\Ship\Actions\Action;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use App\Containers\SchoolsSection\Grades\Actions\MapPointsToLetterAction;

class CreateGradesAction extends Action
{
    public function run(StoreGradesRequest $request, Tutor $tutor, Subject $subject)
    {
        $grades = null;

        DB::transaction(function () use ($request, &$grades, $tutor, $subject) {
            $assessments = $request->validated()['assessments'];
            $studentId = $request->validated()['student_id'];

            // Calculate the weighted average grade
            $totalWeightage = 0;
            $totalGradePoints = 0;

            foreach ($assessments as $assessment) {
                $weightage = $assessment['weightage'];
                $grade = $assessment['grade'];
                $totalWeightage += $weightage;
                $totalGradePoints += $grade * $weightage;
            }

            $finalGradeValue = $totalGradePoints / $totalWeightage;

            // Map the grade value to a letter grade
            $letterGrade = app(MapPointsToLetterAction::class)->run($finalGradeValue);

            // Create or update the grade record
            $grades = Grade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $subject->id,
                    'tutor_id' => $tutor->id,
                ],
                [
                    'grade' => $letterGrade,
                    'grade_value' => $finalGradeValue,
                    'comments' => $request->validated()['comments'],
                    'graded_at' => $request->validated()['graded_at']
                ]
            );
        });

        return $grades;
    }
}
