<?php


namespace App\Containers\UsersSection\Tutors\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use Illuminate\Http\JsonResponse;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use Illuminate\Support\Facades\Log;

class TutorDashboardController extends Controller
{
    public function studentPerformance(Tutor $tutor, Term $term): JsonResponse
    {
        // Log the request for debugging
        Log::info("Fetching performance for Tutor ID: {$tutor->id}, Term ID: {$term->id}");

        // Get the subjects taught by the specified tutor
        $subjects = $tutor->subjects()
            ->with(['grades.student' => function ($query) {
                // Here we eager load the student relationship
            }, 'grades' => function ($query) use ($term) {
                $query->where('term_id', $term->id);
            }])
            ->get();

        // Prepare the response data
        $responseData = [];

        foreach ($subjects as $subject) {
            $subjectData = [
                'subject_code' => $subject->code,
                'subject_name' => $subject->name,
                'grades' => [],
            ];

            foreach ($subject->grades as $grade) {
                $student = $grade->student; // Assuming you have a student relationship in your Grade model
                $subjectData['grades'][] = [
                    'student_id' => $grade->student_id,
                    'student_first_name' => $student->first_name, // Get the student's first name
                    'student_last_name' => $student->last_name, // Get the student's last name
                    'grade_value' => $grade->grade_value,
                ];
            }

            $responseData[] = $subjectData;
        }

        return response()->json([
            "statistics" => $responseData
        ], 200);
    }

    public function getStudentPerSubject(Tutor $tutor): JsonResponse
    {
        $subjects = $tutor->subjects()->withCount('students')->get();

        $responseData = [];

        foreach ($subjects as $subject) {
            $responseData[] = [
                'subject_code' => $subject->code,
                'subject_name' => $subject->name,
                'student_count' => $subject->students_count,
            ];
        }

        return response()->json(['students'=>$responseData],200);
    }


    
}

