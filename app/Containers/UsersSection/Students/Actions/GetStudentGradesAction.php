<?php


namespace App\Containers\UsersSection\Students\Actions;

use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
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
        $grades = Grade::join('students','grades.student_id', '=','students.id')
            ->join('subjects','grades.subject_id', '=', 'subjects.id')
            ->where('students.id',$student->id)
            ->select('subjects.name as subject_name', 'subjects.code as subject_code','grades.grade as letter_grade', 'grades.grade_value as number_grade', 'grades.comments as grade_comments')
            ->get();
        return $grades;
    }
}
