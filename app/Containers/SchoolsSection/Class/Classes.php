<?php

namespace App\Containers\SchoolsSection\Class;
use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;
use App\Containers\SchoolsSection\Class\Resources\ClassroomResource;
use App\Containers\SchoolsSection\Class\Resources\ClassroomResourceCollection;
class Classes
{
    public function resource(ClassModel $class): ClassroomResource
    {
        return new ClassroomResource($class);
    }
    public function resourceCollection($classes): ClassroomResourceCollection
    {
        return new ClassroomResourceCollection($classes);
    }

}
