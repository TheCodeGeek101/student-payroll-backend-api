<?php
namespace App\Containers\UsersSection\Tutors\Actions;

use App\Ship\Actions\Action;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;

class GetEnrolledStudentsAction extends Action
{
    public function run(Tutor $tutor,Subject $subject)
    {
        $students = Tutor::join('subject_tutor','subject_tutor.tutor_id','=','tutors.id')
            ->join('subjects','subject_tutor.subject_id','=','subjects.id')
            ->join('student_subject','student_subject.subject_id','=','subjects.id')
            ->join('students','students.id','=','student_subject.student_id')
            ->where('tutors.id',$tutor->id)
            ->where('subjects.id',$subject->id)
            ->select('students.id as student_id','students.first_name as student_first_name','students.last_name as student_last_name','subjects.name as subject_name','subjects.code as subject_code')
            ->get();
        return $students;
//        $subjects = $tutor->subjects()
//            ->with('students')
//            ->get();
//
//        $subjectsWithStudents = $subjects->map(function($subject) {
//            return [
//                'subject' => $subject
//            ];
//        });
//
//        return $subjectsWithStudents;
    }
}
