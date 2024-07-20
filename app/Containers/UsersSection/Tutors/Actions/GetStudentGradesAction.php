<?php


namespace App\Containers\UsersSection\Tutors\Actions;

use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use Illuminate\Support\Facades\DB;
use App\Ship\Actions\Action;
class GetStudentGradesAction extends Action
{
    /**
     * Retrieve student grades based on tutor.
     *
     * @param int $tutorId
     * @return \Illuminate\Support\Collection
     */
    public function run(Tutor $tutor)
    {
        // Validate input
        if (!$tutor->id) {
            return response()->json(['error' => 'Invalid tutor ID'], 400);
        }

        // Fetch grades for all students in subjects taught by the specified tutor
        $grades = DB::table('grades')
            ->join('subjects', 'grades.subject_id', '=', 'subjects.id')
            ->join('students', 'grades.student_id', '=', 'students.id')
            ->join('tutors', 'grades.tutor_id', '=', 'tutors.id')
            ->where('tutors.id', $tutor->id)
            ->select('grades.grade','grades.comments', 'students.first_name as first_name', 'students.last_name as last_name' , 'subjects.name as subject_name')
            ->get();

        return $grades;
    }
}
