<?php

namespace App\Containers\SchoolsSection\Assessments\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Assessments\Requests\UpdateAssessmentRequest;
use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
class UpdateAssessmentAction extends Action
{
    public function run(UpdateAssessmentRequest $request,Assessment $assessment)
    {
        $updateAssessment =  $assessment->update(
            $request->validated()
         );
        return $updateAssessment;
    }

}
