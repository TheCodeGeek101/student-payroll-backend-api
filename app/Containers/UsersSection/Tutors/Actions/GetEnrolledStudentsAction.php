<?php
namespace App\Containers\UsersSection\Tutors\Actions;

use App\Ship\Actions\Action;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;

class GetEnrolledStudentsAction extends Action
{
    public function run(Tutor $tutor)
    {
        $subjects = $tutor->subjects()
            ->with('students')
            ->get();

        $subjectsWithStudents = $subjects->map(function($subject) {
            return [
                'subject' => $subject
            ];
        });

        return $subjectsWithStudents;
    }
}
