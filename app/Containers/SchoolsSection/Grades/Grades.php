<?php

namespace App\Containers\SchoolsSection\Grades;
use App\Containers\SchoolsSection\Grades\Resources\GradesResource;
use App\Containers\SchoolsSection\Grades\Resources\GradesResourceCollection;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
class Grades
{
    public function resource(Grade $grade): GradesResource
    {
        return new GradesResource($grade);
    }
    public function resourceCollection($grades): GradesResourceCollection
    {
        return new GradesResourceCollection($grades);
    }

}
