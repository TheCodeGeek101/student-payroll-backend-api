<?php

namespace App\Containers\SchoolsSection\Class\Controllers;

use App\Containers\SchoolsSection\Class\Requests\UpdateClassroomRequest;
use App\Http\Controllers\Controller;
use App\Containers\SchoolsSection\Class\Requests\StoreClassroomRequest;
use App\Containers\SchoolsSection\Class\Actions\CreateClassroomAction;
use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;
use Illuminate\Http\JsonResponse;
use App\Containers\SchoolsSection\Class\Resources\ClassroomResource;
use App\Containers\SchoolsSection\Class\Actions\UpdateClassroomAction;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;

class ClassroomController extends Controller
{
    public function index(): JsonResponse
    {
        $classes = ClassModel::all();
        return response()->json([
            'classes' => $classes
        ], 200);
    }

    public function store(StoreClassroomRequest $request, Tutor $tutor): JsonResponse
    {
        $newClass = app(CreateClassroomAction::class)->run($request, $tutor);
        if ($newClass) {
            return response()->json([
                'message' => 'Class created successfully',
                'class' => new ClassroomResource($newClass)
            ], 201);
        } else {
            return response()->json([
                'message' => 'Class cannot be created',
            ], 500);
        }
    }

    public function show(ClassModel $class): JsonResponse
    {
        return response()->json(
            new ClassroomResource($class),
            200
        );
    }

    public function update(UpdateClassroomRequest $request, ClassModel $class): JsonResponse
    {
        $updatedClass = app(UpdateClassroomAction::class)->run($request, $class);
        return response()->json([
            'message' => 'Class updated successfully',
            'class' => new ClassroomResource($updatedClass)
        ], 200);
    }

    public function destroy(ClassModel $class): JsonResponse
    {
        $class->delete();
        return response()->json([
            'message' => 'Class deleted successfully'
        ], 200);
    }
}
