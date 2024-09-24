<?php

namespace App\Containers\SchoolsSection\Assessments\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Assessments\Requests\UpdateAssessmentRequest;
use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;

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
