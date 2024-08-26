<?php
namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Containers\SchoolsSection\Classes\Data\Models\SchoolClass;
use Illuminate\Support\Facades\Log;

class CalculateOverallResultsAction extends Action
{
    const FINAL_CLASS_ID = 4; // Representing Form 4

    public function run(Student $student): array
    {
        try {
            // Fetch all terms with grades for the student
            $terms = Term::whereHas('grades', function($query) use ($student) {
                $query->where('student_id', $student->id);
            })->get();

            // Early return if no terms found
            if ($terms->isEmpty()) {
                return [
                    'status' => 'No Data',
                    'message' => 'No grades found for this student.',
                    'overall_average' => 0,
                    'term_averages' => []
                ];
            }

            $termAverages = [];
            $cumulativeAverage = 0;

            foreach ($terms as $term) {
                $grades = Grade::where('student_id', $student->id)
                    ->where('term_id', $term->id)
                    ->get();

                if ($grades->isEmpty()) {
                    continue;
                }

                $averageResults = $grades->avg('grade_value');

                // Store the term average
                $termAverages[] = [
                    'term' => $term->name,
                    'average' => $averageResults
                ];

                // Add to cumulative average for all terms
                $cumulativeAverage += $averageResults;
            }

            // Calculate overall average across all terms
            $overallAverage = $cumulativeAverage / count($termAverages);

            // Determine pass or fail based on overall average
            if ($overallAverage >= 50) {
                // Check if the student is in the final class
                if ($student->class_id < self::FINAL_CLASS_ID) {
                    // Promote the student to the next class
                    $student->class_id += 1;
                    $student->save();

                    $status = 'Proceed';
                    $message = 'Congratulations! You have an overall average score of ' . number_format($overallAverage, 2) .
                        '. You may proceed to the next class (Form ' . $student->class_id . ').';
                } else {
                    // The student has completed the final class
                    $status = 'Graduated';
                    $message = 'Congratulations! You have successfully completed Form ' . self::FINAL_CLASS_ID . ' with an overall average score of ' .
                        number_format($overallAverage, 2) . '. You have graduated from secondary school.';
                }
            } else {
                // The student has failed
                $status = 'Withdraw';
                $message = 'Unfortunately, your overall average score is ' . number_format($overallAverage, 2) .
                    '. You have been withdrawn on academic grounds.';
            }

            return [
                'status' => $status,
                'message' => $message,
                'overall_average' => $overallAverage,
                'term_averages' => $termAverages
            ];

        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::error('Error calculating overall results: ' . $e->getMessage(), ['student_id' => $student->id]);

            return [
                'status' => 'Error',
                'message' => 'An error occurred while calculating the results. Please try again later.',
                'overall_average' => 0,
                'term_averages' => []
            ];
        }
    }
}
