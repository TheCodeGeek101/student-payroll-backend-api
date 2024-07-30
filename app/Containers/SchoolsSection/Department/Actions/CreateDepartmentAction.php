<?php

namespace App\Containers\SchoolsSection\Department\Actions;

use App\Containers\SchoolsSection\Department\Data\Models\Department;
use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Department\Requests\StoreDepartmentRequest;
use Illuminate\Support\Facades\DB;
class CreateDepartmentAction extends Action
{
    public function run(StoreDepartmentRequest $request)
    {
        $department = null;
        DB::transaction(function () use ($request, &$department) {
           $department = Department::create($request->validated());
        });
        return $department;

    }
}
