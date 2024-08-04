<?php

namespace App\Containers\SchoolsSection\Subjects\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
class GetSubjectTutorsAction extends Action
{
    public function run()
    {
        $subjectTutors = Subject::join('subject_tutor', 'subject_tutor.subject_id', '=', 'subjects.id')
            ->join('tutors', 'tutors.id', '=', 'subject_tutor.tutor_id')
            ->join('administrators', 'administrators.id', '=', 'subject_tutor.assigned_by')
            ->join('departments','departments.id','=','subjects.department_id')
            ->join('classroom','classroom.id','=','subjects.class_id')
            ->select('tutors.first_name as tutor_first_name', 'tutors.last_name as tutor_last_name', 'administrators.full_name as assigned_by', 'subjects.name as subject_name', 'subjects.code as subject_code','departments.name as department_name','classroom.name as class_name')
            ->get();
        return $subjectTutors;

    }

}
