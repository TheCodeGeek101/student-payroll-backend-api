<?php

namespace App\Containers\SchoolsSection\Subjects;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\SchoolsSection\Grades\Resources\GradesResource;
use App\Containers\SchoolsSection\Grades\Resources\GradesResourceCollection;

class Subjects
{
    public function resources(Grade $grade): GradesResource
    {
        return new GradesResource($grade);
    }

    public function resourceCollection($grades): GradesResourceCollection
    {
        return new GradesResourceCollection($grades);
    }
}
