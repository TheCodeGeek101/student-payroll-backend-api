<?php


namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\UsersSection\Students\Data\Models\Student;

class CalculateOverallResultsAction extends Action
{
    public function run(Student $student): array
    {
        try {
            // Retrieve grades and calculate total and average results
            $results = Grade::join('subjects', 'grades.subject_id', '=', 'subjects.id')
                ->join('students', 'grades.student_id', '=', 'students.id')
                ->join('classroom', 'students.class_id', '=', 'classroom.id')
                ->join('terms','grades.term_id','=', 'term.id')
                ->where('students.id', $student->id)
                ->select(
                    'grades.grade_value as grade_value',
                    'grades.grade as grade',
                    'subjects.name as subject_name',
                    'students.first_name as student_name',
                    'students.last_name as student_last_name',
                    'classroom.id as class_id',
                    'terms.name  as term_name'
                )
                ->get();

            if ($results->isEmpty()) {
                return [
                    'status' => 'No Data',
                    'message' => 'No grades found for this student.',
                    'average' => 0
                ];
            }

            // Calculate the total and average grade value
            $totalResults = $results->sum('grade_value');
            $averageResults = $totalResults / $results->count();

            // Prepare the response data
            return [
                'status' => $averageResults >= 50 ? 'Pass' : 'Fail',
                'message' => $averageResults >= 50
                    ? 'Congratulations! You have passed the exam with an average score of ' . number_format($averageResults, 2) . '. Keep up the good work!'
                    : 'Unfortunately, you have not passed the exam. Your average score is ' . number_format($averageResults, 2) . '. Please review the material and seek help if needed.',
                'average' => $averageResults
            ];

        } catch (\Exception $e) {
            // Handle exceptions and provide a meaningful error message
            return [
                'status' => 'Error',
                'message' => 'An error occurred while calculating results: ' . $e->getMessage(),
                'average' => 0
            ];
        }
    }
}
