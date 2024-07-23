<?php
namespace App\Containers\SchoolsSection\Class\Actions;

use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;
use App\Containers\SchoolsSection\Class\Requests\StoreClassroomRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateClassroomAction extends Action
{
    public function run(StoreClassroomRequest $request, Tutor $tutor)
    {
        $class = null;
        try {
            DB::transaction(function () use ($request, &$class, $tutor) {
                $class = ClassModel::create(array_merge($request->validated(), ['tutor_id' => $tutor->id]));
            });
            Log::info('Class created successfully:', $class->toArray());
        } catch (\Exception $e) {
            Log::error('Error creating class: ' . $e->getMessage());
            throw $e; // Rethrow exception for higher-level handling
        }
        return $class;
    }
}
