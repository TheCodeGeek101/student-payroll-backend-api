<?php

namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Grades\Data\Models\Grades;
use App\Containers\SchoolsSection\Grades\Requests\UpdateGradesRequest;
class UpdateGradesAction extends Action
{
    public function run(UpdateGradesRequest $request, Grades $grades){
        $grades->update($request->validated());
        return $grades;
    }

}
