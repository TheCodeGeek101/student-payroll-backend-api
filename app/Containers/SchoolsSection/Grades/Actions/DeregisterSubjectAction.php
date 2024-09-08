<?php
namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Ship\Actions\Action;
use Illuminate\Support\Facades\DB;

class DeregisterSubjectAction extends Action
{
    public function run(Student $student)
    {
        // Directly delete the subjects the student took in that particular class
        DB::table('student_subject')
            ->where('student_id', $student->id)
            ->where('class_id', $student->class_id)
            ->delete();
    }
}
