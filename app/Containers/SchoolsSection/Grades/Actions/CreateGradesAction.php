<?php

namespace App\Containers\SchoolsSection\Grades\Actions;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\SchoolsSection\Grades\Requests\StoreGradesRequest;
use Illuminate\Support\Facades\DB;
use App\Ship\Actions\Action;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;

class CreateGradesAction extends Action
{
    public function run(StoreGradesRequest $request, Tutor $tutor){
        $grades = null;
        DB::transaction(function () use ($request, &$grades, $tutor){
           $grades = Grade::create(
               array_merge($request->validated(),
                   ['tutor_id' => $tutor->id]));
        });
        return $grades;
    }
}
