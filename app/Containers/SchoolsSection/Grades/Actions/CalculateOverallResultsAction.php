<?php
namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\UsersSection\Students\Data\Models\Student;
use Illuminate\Support\Facades\DB;

class CalculateOverallResultsAction extends Action
{
    public function run(Student $student)
    {
        // Retrieve grades and calculate total and average results
        $results = Grade::join('subjects', 'grades.subject_id', '=', 'subjects.id')
            ->join('students', 'grades.student_id', '=', 'students.id')
            ->join('classroom', 'students.class_id', '=', 'classroom.id')
            ->where('students.id', $student->id)
            ->select(
                'grades.grade_value as grade_value',
                'grades.grade as grade',
                'subjects.name as subject_name',
                'students.first_name as student_name',
                'students.last_name as student_last_name',
                'classroom.id as class_id'
            )
            ->get();

        // Calculate the total and average grade value
        $totalResults = $results->sum('grade_value');
        $averageResults = ($results->count() > 0) ? ($totalResults / $results->count()) : 0;

        // Determine pass or fail message
        if ($averageResults >= 50) {
            $results = [
                'status' => 'Pass',
                'message' => 'Congratulations! You have passed the exam with an average score of ' . number_format($averageResults, 2) . '. Keep up the good work!',
                'results' => $averageResults
            ];
        } else {
            $results = [
                'status' => 'Fail',
                'message' => 'Unfortunately, you have not passed the exam. Your average score is ' . number_format($averageResults, 2) . '. Please review the material and seek help if needed.',
                'results' => $averageResults
            ];
        }

        return $results;
    }
}
