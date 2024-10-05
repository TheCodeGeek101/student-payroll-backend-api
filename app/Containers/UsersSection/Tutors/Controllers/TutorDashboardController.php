<?php

namespace App\Containers\UsersSection\Tutors\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
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
        ->with(['grades' => function ($query) use ($term) {
            // Corrected: Use $term->id to filter by term ID
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
            $subjectData['grades'][] = [
                'student_id' => $grade->student_id,
                'grade_value' => $grade->grade_value,
            ];
        }

        $responseData[] = $subjectData;
    }

    return response()->json($responseData);
}

}
