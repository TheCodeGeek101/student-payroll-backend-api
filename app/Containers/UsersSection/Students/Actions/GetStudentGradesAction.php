<?php


namespace App\Containers\UsersSection\Students\Actions;

use App\Ship\Actions\Action;
use App\Containers\UsersSection\Students\Data\Models\Student;
use Illuminate\Support\Facades\DB;

class GetStudentGradesAction extends Action
{
    public function run(Student $student)
    {
        // Validate input
        if (!$student->id) {
            return response()->json(['error' => 'Invalid student ID'], 400);
        }

        // Fetch grades for the specific student
        $grades = DB::table('grades')
            ->join('subjects', 'grades.subject_id', '=', 'subjects.id')
            ->join('tutors', 'grades.tutor_id', '=', 'tutors.id')
            ->join('students', 'grades.student_id', '=', 'students.id')
            ->where('grades.student_id', $student->id)
            ->select('grades.*', 'subjects.name as subject', 'subjects.code as subject_code','subjects.description as subject_description', 'subjects.credits as subject_credit_hours', 'subjects.year_of_study as subject_class')
            ->get();

        return response()->json($grades);
    }
}
