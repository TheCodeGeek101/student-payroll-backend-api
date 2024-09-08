<?php


namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Ship\Actions\SubAction;
use App\Containers\UsersSection\Students\Data\Models\Student;
use Illuminate\Support\Facades\Log;

class GetStudentCurrentClassAction extends SubAction
{
    public function run(Student $student)
    {
        try {
            // Fetch the latest promotion record for the student
            $class = Student::join('promoted_class', 'promoted_class.student_id', '=', 'students.id')
                ->where('students.id', $student->id)
                ->orderBy('promoted_class.created_at', 'desc') // Ensure you get the most recent class
                ->select('promoted_class.class_id as current_class')
                ->first();

            if (!$class) {
                return [
                    'status' => 'not_found',
                    'message' => 'No current class found for this student.'
                ];
            }

            return [
                'status' => 'success',
                'current_class' => $class->current_class
            ];
        } catch (\Exception $e) {
            // Log the error with additional context
            Log::error('Error retrieving current class for student: ' . $e->getMessage(), [
                'student_id' => $student->id,
                'error' => $e->getTraceAsString()
            ]);

            return [
                'status' => 'error',
                'message' => 'An error occurred while retrieving the current class. Please try again later.'
            ];
        }
    }
}
