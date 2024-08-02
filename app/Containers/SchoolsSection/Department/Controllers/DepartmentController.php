<?php

namespace App\Containers\SchoolsSection\Department\Controllers;

use App\Containers\SchoolsSection\Department\Data\Models\Department;
use App\Containers\SchoolsSection\Department\Requests\UpdateDepartmentRequest;
use App\Containers\SchoolsSection\Department\Resources\DepartmentResource;
use App\Http\Controllers\Controller;
use App\Containers\SchoolsSection\Department\Requests\StoreDepartmentRequest;
use App\Containers\SchoolsSection\Department\Actions\CreateDepartmentAction;
use Illuminate\Http\JsonResponse;
use App\Containers\SchoolsSection\Department\Actions\UpdateDepartmentAction;

class DepartmentController extends Controller
{
    public function index(): JsonResponse
    {
        $departments = Department::all();
        return response()->json(['departments' =>$departments],200);
    }
    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        $newDepartment = app(CreateDepartmentAction::class)->run($request);
        return response()->json(['message' => 'Department created successfully','department' =>$newDepartment],201);
    }
    public function show(Department $department): JsonResponse
    {
        $department = Department::join('tutors', 'tutors.id', '=', 'departments.head_of_department')
            ->where('departments.id','=', $department->id)
            ->select('departments.*', 'tutors.first_name as tutor_first_name','tutors.last_name as tutor_last_name')
            ->first();
        return response()->json($department,200);
    }

    public function update(UpdateDepartmentRequest $request, Department $department): JsonResponse
    {
        $updateDepartment = app(UpdateDepartmentAction::class)->run($request,$department);
        return response()->json(['message' => 'Department updated successfully','department' =>$updateDepartment],200);
    }
    public function destroy(Department $department): JsonResponse
    {
        $department->delete();
        return response()->json(['message' => 'Department deleted successfully'],200);
    }
}
