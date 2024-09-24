<?php

namespace App\Containers\UsersSection\Students\Actions;

use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Ship\Actions\Action;
use App\Containers\UsersSection\Students\Data\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetStudentGradesAction extends Action
{
    public function run(Request $request, Student $student, Term $term): array
    {
        // Validate request
        $data = $request->validate([
            'class_id' => 'required|exists:classroom,id'  // Check the table name 'classrooms'
        ]);

        try {
            // Fetch grades for the specific student, term, and class
            $grades = Grade::join('subjects', 'subjects.id', '=', 'grades.subject_id')
                ->join('terms', 'terms.id', '=', 'grades.term_id')
                ->join('classroom', 'classroom.id', '=', 'grades.class_id')  // Ensure table name is 'classrooms'
                ->join('students', 'students.id', '=', 'grades.student_id')    // Join with 'students' table
                ->where('students.id', '=', $student->id)                      // Use $student->id
                ->where('terms.id', '=', $term->id)                            // Use $term->id
                ->where('classroom.id', '=', $data['class_id'])               // Use class ID from validated data
                ->select(
                    'subjects.name as subject_name',
                    'subjects.code as subject_code',
                    'grades.grade as letter_grade',
                    'grades.grade_value as number_grade',
                    'grades.comments as grade_comments',
                    'terms.name as term_name',
                    'classroom.name as class_name'
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

            // Calculate total and average grade value
            $totalResults = $grades->sum('number_grade');
            $averageResults = $totalResults / $grades->count();

            // Prepare the response with grades and average results
            return [
                'status' => $averageResults >= 50 ? 'Pass' : 'Fail',
                'message' => $averageResults >= 50
                    ? 'Congratulations! You have passed the exam with an average score of ' . number_format($averageResults, 2) . '. Keep up the good work!'
                    : 'Unfortunately, you have not passed the exam. Your average score is ' . number_format($averageResults, 2) . '. Please review the material and seek help if needed.',
                'average' => $averageResults,
                'grades' => $grades
            ];

        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error fetching student grades: ' . $e->getMessage());

            // Return error response
            return [
                'status' => 'Error',
                'message' => 'An error occurred while fetching grades: ' . $e->getMessage(),
                'average' => 0
            ];
        }
    }
}
