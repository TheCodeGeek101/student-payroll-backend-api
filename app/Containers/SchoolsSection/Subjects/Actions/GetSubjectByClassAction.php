<?php

namespace App\Containers\SchoolsSection\Subjects\Actions;
use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use Illuminate\Http\Request;

class GetSubjectByClassAction extends Action
{
    public function run(Request $request)
    {
        $subject = Subject::where('year_of_study',$request->year_of_study)->get();
        return $subject;
    }

}
