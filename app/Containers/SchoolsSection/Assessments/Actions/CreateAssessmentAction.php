<?php
namespace App\Containers\SchoolsSection\Assessments\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;
use App\Containers\SchoolsSection\Assessments\Requests\StoreAssessmentRequest;
use Illuminate\Support\Facades\DB;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;

class CreateAssessmentAction extends Action
{
    public function run(StoreAssessmentRequest $request, Tutor $tutor, Subject $subject)
    {
        $assessment = null;

        DB::transaction(function () use ($request, &$assessment, $subject, $tutor) {
            // Calculate the score as a fraction of the total marks
            $gradeValue = $request->validated()['score'] / $request->validated()['total_marks'];
            // Adjust the score to reflect 40% of the final grade


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
