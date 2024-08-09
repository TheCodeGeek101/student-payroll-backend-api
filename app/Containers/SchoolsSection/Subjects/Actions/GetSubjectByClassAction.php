<?php

namespace App\Containers\SchoolsSection\Subjects\Actions;
use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;
use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use Illuminate\Http\Request;

class GetSubjectByClassAction extends Action
{
    public function run(Request $request,ClassModel $classroom)
    {
        $subject = Subject::join('classroom','subject.class_id','=','classroom.id')
            ->where('classroom.id',$classroom->id)
            ->select('subject.*','classroom.name as class_name')
            ->get();
        return $subject;
    }

}
