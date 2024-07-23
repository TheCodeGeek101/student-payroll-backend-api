<?php

namespace App\Containers\SchoolsSection\Class\Actions;

use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;
use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Class\Requests\UpdateClassroomRequest;
class UpdateClassroomAction extends Action
{
    public function run(UpdateClassroomRequest $request,ClassModel $class)
    {
        $updatedClass = $class->update($request->validated());
        return $updatedClass;
    }

}
