<?php
namespace App\Containers\UsersSection\Students\Actions;

use App\Ship\Actions\Action;
use App\Containers\UsersSection\Students\Data\Models\Student;

class GetEnrolledSubjectAction extends Action
{
    public function run(Student $student)
    {
        $enrolledSubjects = $student->subjects()->get();
        return $enrolledSubjects;
    }
}
