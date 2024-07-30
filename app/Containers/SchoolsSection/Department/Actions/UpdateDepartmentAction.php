<?php

namespace App\Containers\SchoolsSection\Department\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Department\Requests\UpdateDepartmentRequest;
use App\Containers\SchoolsSection\Department\Data\Models\Department;
class UpdateDepartmentAction extends Action
{
    public function run(UpdateDepartmentRequest $request, Department $department)
    {
        $updated = $department->update($request->validated());
        return $updated;
    }
}
