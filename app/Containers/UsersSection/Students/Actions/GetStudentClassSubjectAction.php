<?php


namespace App\Containers\UsersSection\Students\Actions;

use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use App\Ship\Actions\Action;
use App\Containers\UsersSection\Students\Data\Models\Student;

class GetStudentClassSubjectAction extends Action
{
    public function run(Student $student)
    {
        // Fetch all subjects where the class_id matches the student's class_id
        return Subject::where('class_id', $student->class_id)->get();
    }
}
