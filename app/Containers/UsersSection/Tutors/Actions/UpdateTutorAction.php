<?php


namespace App\Containers\UsersSection\Tutors\Actions;

use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\UsersSection\Tutors\Requests\UpdateTutorRequest;
use App\Ship\Actions\Action;

class UpdateTutorAction extends Action
{
    public function run(UpdateTutorRequest $request, Tutor $tutor): Tutor
    {
        $tutor->update($request->validated());
        return $tutor;
    }
}
