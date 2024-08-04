<?php

namespace App\Containers\SchoolsSection\Assessments;
use App\Containers\SchoolsSection\Assessments\Resources\AssessmentResource;
use App\Containers\SchoolsSection\Assessments\Resources\AssessmentResourceCollection;
class Assessments
{
    public function resource(AssessmentResource $assessmentResource): AssessmentResource
    {
        return new AssessmentResource($assessmentResource);
    }
    public function resourceCollection($assessments): AssessmentResourceCollection
    {
        return new AssessmentResourceCollection($assessments);
    }
}
