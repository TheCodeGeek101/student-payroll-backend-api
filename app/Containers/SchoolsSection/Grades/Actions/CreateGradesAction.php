<?php

namespace App\Containers\SchoolsSection\Grades\Actions;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\SchoolsSection\Grades\Requests\StoreGradesRequest;
use Illuminate\Support\Facades\DB;
use App\Ship\Actions\Action;

class CreateGradesAction extends Action
{
    public function run(StoreGradesRequest $request){
        $grades = null;
        DB::transaction(function () use ($request, &$grades){
           $grades = Grade::create($request->validated());
        });
        return $grades;
    }
}
