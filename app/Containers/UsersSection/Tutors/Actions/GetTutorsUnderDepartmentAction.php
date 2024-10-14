<?php

namespace App\Containers\UsersSection\Tutors\Actions;

use App\Ship\Actions\Action;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;

class GetTutorsUnderDepartmentAction extends Action
{
    public function run(Subject $subject)
    {
        $selectedTutor = Tutor::join('departments', 'departments.id', '=', 'tutors.department_id')
            ->join('subjects', 'subjects.department_id', '=', 'departments.id')
            ->where('subjects.id', $subject->id)
            ->select('tutors.*', 'departments.name as department_name', 'subjects.name as subject_name')
            ->get();

        return $selectedTutor;
    }
}


