<?php
namespace App\Containers\SchoolsSection\Assessments\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;
use App\Containers\SchoolsSection\Assessments\Requests\StoreAssessmentRequest;
use Illuminate\Support\Facades\DB;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\SchoolsSection\Assessments\Exceptions\GradeAlreadyExistsException;

class CreateAssessmentAction extends Action
{
    public function run(StoreAssessmentRequest $request, Tutor $tutor, Subject $subject)
    {
        // Check if an assessment already exists for the student, subject, and term
        $existingAssessment = Assessment::where('student_id', $request->validated()['student_id'])
            ->where('subject_id', $subject->id)
            ->where('term_id', $request->validated()['term_id']) // Assuming 'term_id' is part of the request
            ->first();

        if ($existingAssessment) {
            // If an assessment already exists, throw a custom exception
            throw new GradeAlreadyExistsException();
        }

        $assessment = null;

        DB::transaction(function () use ($request, &$assessment, $subject, $tutor) {
            // Calculate the score as a fraction of the total marks
            $gradeValue = $request->validated()['score'] / $request->validated()['total_marks'];

            // Store the assessment data along with calculated score
            $assessment = Assessment::create(
                array_merge(
                    $request->validated(),
                    [
                        'tutor_id' => $tutor->id,
                        'subject_id' => $subject->id,
                        'grade_value' => $gradeValue // Assuming 'score' field exists in Assessment model
                    ]
                )
            );
        });

        return $assessment;
    }
}
