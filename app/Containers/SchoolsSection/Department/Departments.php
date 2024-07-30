<?php

namespace App\Containers\SchoolsSection\Department;
use App\Containers\SchoolsSection\Department\Resources\DepartmentResource;
use App\Containers\SchoolsSection\Department\Resources\DepartmentResourceCollection;
use App\Containers\SchoolsSection\Department\Data\Models\Department;
class Departments
{
    public function resource(Department $department): DepartmentResource
    {
        return new DepartmentResource($department);
    }
    public function resourceCollection($departments): DepartmentResourceCollection
    {
        return new DepartmentResourceCollection($departments);
    }

}
