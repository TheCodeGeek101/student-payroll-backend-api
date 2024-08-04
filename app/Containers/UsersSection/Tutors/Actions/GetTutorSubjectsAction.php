<?php
namespace App\Containers\UsersSection\Tutors\Actions;

use App\Ship\Actions\Action;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;

class GetTutorSubjectsAction extends Action
{
    public function run(Tutor $tutor)
    {
        // Fetch subjects associated with the tutor
        $tutorSubjects = Tutor::join('subject_tutor', 'subject_tutor.tutor_id', '=', 'tutors.id')
            ->join('subjects', 'subjects.id', '=', 'subject_tutor.subject_id')
            ->join('departments', 'departments.id', '=', 'subjects.department_id')
            ->join('classroom', 'classroom.id', '=', 'subjects.class_id')
            ->select('subjects.*', 'departments.name as department_name', 'classroom.name as class_name', 'tutors.first_name as tutor_first_name', 'tutors.last_name as tutor_last_name')
            ->where('tutors.id',$tutor->id)
            ->get();

        if ($tutorSubjects->isEmpty()) {
            // Handle the case where the tutor does not have any subjects
            return response()->json(['error' => 'No subjects found for the tutor'], 404);
        }

        // Return the subjects
        return $tutorSubjects;
    }
}
