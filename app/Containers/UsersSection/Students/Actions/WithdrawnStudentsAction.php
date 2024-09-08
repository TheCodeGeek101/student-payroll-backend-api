<?php

namespace App\Containers\UsersSection\Students\Actions;

use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;

class WithdrawnStudentsAction extends Action
{

    public function run()
    {
        $students = Student::join('classroom', 'classroom.id', 'students.class_id')
            ->where('enrollment_status', '=', 'withdrawn')
            ->select('classroom.name as class_name', 'students.*')
            ->get();
        return $students;
    }
}
