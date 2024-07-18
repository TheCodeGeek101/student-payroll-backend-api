<?php

namespace App\Containers\SchoolsSection\Subjects\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Subjects\Requests\UpdateSubjectRequest;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;

class UpdateSubjectAction extends Action
{
    public function run(UpdateSubjectRequest $request, Subject $subject) {
        // Update the subject with validated data
        $subject->update($request->validated());
        return $subject;
    }

}
