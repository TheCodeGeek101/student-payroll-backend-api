<?php

namespace App\Containers\UsersSection\Students\Controllers;

use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;

class StudentDashboardController extends Controller
{
    public function gradeSummary(Student $student, Term $term): JsonResponse
    {   
        // Fetch grades for the specific student and term
        $grades = Grade::join('students', 'students.id', '=', 'grades.student_id')
                       ->join('terms', 'terms.id', '=', 'grades.term_id')
                       ->join('subjects', 'subjects.id', '=', 'grades.subject_id')
                       ->where('students.id', '=', $student->id)
                       ->where('terms.id', '=', $term->id)
                       ->select(
                           'grades.grade_value',
                           'terms.name as term_name',
                           'subjects.name as subject_name',
                           'subjects.code as subject_code'
                       )
                       ->get();

        // Check if grades are found
        if ($grades->isEmpty()) {
            return response()->json(['message' => 'No grades found for this student in the specified term.'], 404);
        }

        // Calculate statistics
        $totalGrades = $grades->count();
        $averageGradeValue = $grades->avg('grade_value'); // You may need to convert letter grades to numerical for averaging
        $gradeDistribution = $grades->groupBy('grade_value')->map(function ($group) {
            return $group->count();
        });

        // Prepare data for the graph
        $graphData = [
            'term' => $grades->first()->term_name,
            'total_subjects' => $totalGrades,
            'average_grade_value' => $averageGradeValue,
            'grade_distribution' => $gradeDistribution,
            'grades' => $grades->map(function($grade) {
                return [
                    'subject_name' => $grade->subject_name,
                    'subject_code' => $grade->subject_code,
                    'grade_value' => $grade->grade_value,
                ];
            }),
        ];

        return response()->json([
            "statistics" =>$graphData
            ]
            ,200);
    }
}
