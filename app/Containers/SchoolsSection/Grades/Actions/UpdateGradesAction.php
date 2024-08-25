<?php

namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\SchoolsSection\Grades\Requests\UpdateGradesRequest;
class UpdateGradesAction extends Action
{
    public function run(UpdateGradesRequest $request,Grade $grade)
    {
        $updateGrade =  $grade->update(
            $request->validated()
        );
        return $updateGrade;
    }
}
