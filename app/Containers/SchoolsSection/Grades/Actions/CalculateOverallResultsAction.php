<?php
namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;
use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use Illuminate\Support\Facades\Log;
use App\Containers\SchoolsSection\Grades\Actions\GetStudentCurrentClassAction;
use App\Containers\SchoolsSection\Grades\Actions\DetermineStudentClassAction;
use App\Containers\SchoolsSection\Grades\Actions\DeregisterSubjectAction;

class CalculateOverallResultsAction extends Action
{
    const FINAL_CLASS_ID = 4; // Representing Form 4

    public function run(Student $student, ClassModel $class): array
    {
        try {
            // Fetch all terms with grades for the student
            $terms = Term::whereHas('grades', function ($query) use ($student) {
                $query->where('student_id', $student->id);
            })->get();

            $currentClass = app(GetStudentCurrentClassAction::class)->run($student);

            // Early return if less than 3 terms found
            if ($terms->count() < 3) {
                return [
                    'status' => 'No Data',
                    'message' => 'Complete grades for all terms not found for this student.',
                    'overall_average' => 0,
                    'term_averages' => [],
                ];
            }

            $termAverages = [];
            $cumulativeAverage = 0;

            foreach ($terms as $term) {
                $grades = Grade::where('student_id', $student->id)
                    ->where('term_id', $term->id)
                    ->where('class_id', $class->id)
                    ->get();

                if ($grades->isEmpty()) {
                    continue;
                }

                $averageResults = $grades->avg('grade_value');

                // Store the term average
                $termAverages[] = [
                    'term' => $term->name,
                    'average' => $averageResults,
                ];

                // Add to cumulative average
                $cumulativeAverage += $averageResults;
            }

            // Calculate overall average
            $overallAverage = $cumulativeAverage / count($termAverages);

            // Determine promotion status
            if ($overallAverage >= 50) {
                if ($class->id < self::FINAL_CLASS_ID) {
                    if ($this->shouldPromote($student)) {
                        $this->promoteStudent($student);
                        $status = 'Proceed';
                        $message = 'Congratulations! You have an overall average score of ' . number_format($overallAverage, 2) .
                            '. You may proceed to the next class (Form ' . $student->class_id . ').';
                    } else {
                        $status = 'Already Promoted';
                        $message = 'You have already been promoted to the next class.';
                    }
                } else {
                    $this->graduateStudent($student, $overallAverage);
                    $status = 'Graduated';
                    $message = 'Congratulations! You have successfully completed Form ' . self::FINAL_CLASS_ID . ' with an overall average score of ' .
                        number_format($overallAverage, 2) . '. You have graduated from secondary school.';
                }
            } else {
                $this->withdrawStudent($student, $overallAverage);
                $status = 'Withdraw';
                $message = 'Unfortunately, your overall average score is ' . number_format($overallAverage, 2) .
                    '. You have been withdrawn on academic grounds.';
            }

            return [
                'status' => $status,
                'message' => $message,
                'overall_average' => $overallAverage,
                'term_averages' => $termAverages,
            ];

        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::error('Error calculating overall results: ' . $e->getMessage(), ['student_id' => $student->id]);

            return [
                'status' => 'Error',
                'message' => 'An error occurred while calculating the results. Please try again later.',
                'overall_average' => 0,
                'term_averages' => [],
            ];
        }
    }

    private function shouldPromote(Student $student): bool
    {
        return $student->class_id > $student->previous_class_id && !$student->has_promoted;
    }

    private function promoteStudent(Student $student)
    {
        app(DeregisterSubjectAction::class)->run($student);
        $student->previous_class_id = $student->class_id;
        $student->class_id += 1;
        app(DetermineStudentClassAction::class)->run($student, $student->class_id);
        $student->has_promoted = true;
        $student->save();
    }

    private function graduateStudent(Student $student, float $overallAverage)
    {
        // Logic for graduation
        $student->graduation_status = 'Graduated';
        $student->overall_average = $overallAverage;
        $student->save();
    }

    private function withdrawStudent(Student $student, float $overallAverage)
    {
        // Logic for withdrawal
        $student->enrollment_status = 'withdrawn';
        $student->overall_average = $overallAverage;
        $student->save();
    }
}
