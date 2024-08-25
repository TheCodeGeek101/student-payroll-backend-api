<?php

namespace App\Containers\UsersSection\Students\Actions;

use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Ship\Actions\Action;
use App\Containers\UsersSection\Students\Data\Models\Student;

class GetStudentGradesAction extends Action
{
    public function run(Student $student, Term $term): array
    {
        try {
            // Fetch grades for the specific student and term
            $grades = Grade::join('subjects', 'grades.subject_id', '=', 'subjects.id')
                ->join('terms', 'grades.term_id', '=', 'terms.id')
                ->where('student_id', $student->id)
                ->where('term_id', $term->id)
                ->select(
                    'subjects.name as subject_name',
                    'subjects.code as subject_code',
                    'grades.grade as letter_grade',
                    'grades.grade_value as number_grade',
                    'grades.comments as grade_comments',
                    'terms.name as term_name'
                )
                ->get();

            // If no grades are found, return a 'No Data' response
            if ($grades->isEmpty()) {
                return [
                    'status' => 'No Data',
                    'message' => 'No grades found for this student in the specified term.',
                    'average' => 0
                ];
            }

            // Calculate the total and average grade value
            $totalResults = $grades->sum('number_grade');
            $averageResults = $totalResults / $grades->count();

            // Prepare the response data, including grades and overall results
            return [
                'status' => $averageResults >= 50 ? 'Pass' : 'Fail',
                'message' => $averageResults >= 50
                    ? 'Congratulations! You have passed the exam with an average score of ' . number_format($averageResults, 2) . '. Keep up the good work!'
                    : 'Unfortunately, you have not passed the exam. Your average score is ' . number_format($averageResults, 2) . '. Please review the material and seek help if needed.',
                'average' => $averageResults,
                'grades' => $grades
            ];

        } catch (\Exception $e) {
            // Handle exceptions and provide a meaningful error message
            return [
                'status' => 'Error',
                'message' => 'An error occurred while fetching grades and calculating results: ' . $e->getMessage(),
                'average' => 0
            ];
        }
    }
}
