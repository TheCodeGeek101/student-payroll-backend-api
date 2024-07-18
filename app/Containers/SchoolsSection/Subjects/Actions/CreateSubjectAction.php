<?php

namespace App\Containers\SchoolsSection\Subjects\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use Illuminate\Support\Facades\DB;
use App\Containers\SchoolsSection\Subjects\Requests\StoreSubjectRequest;

class CreateSubjectAction extends Action
{
    public function run(StoreSubjectRequest $request)
    {
        $subject = null;
        DB::transaction(function () use ($request, &$subject) {
            $subject = Subject::create($request->validated());
        });

        return $subject;
    }
}
