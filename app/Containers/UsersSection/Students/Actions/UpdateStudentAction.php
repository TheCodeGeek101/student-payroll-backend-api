<?php

namespace App\Containers\UsersSection\Students\Actions;

use App\Ship\Actions\Action;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\UsersSection\Students\Requests\UpdateStudentRequest;

class UpdateStudentAction extends Action
{
    public function run(UpdateStudentRequest $request, Student $student){
        $student->update($request->validated());
        return $student;
    }
}
