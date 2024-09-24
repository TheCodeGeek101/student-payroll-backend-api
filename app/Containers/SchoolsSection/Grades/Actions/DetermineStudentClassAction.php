<?php


namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Ship\Actions\SubAction;
use Illuminate\Support\Facades\DB;
use App\Containers\UsersSection\Students\Data\Models\Student;
use Exception;
use Illuminate\Support\Facades\Log;

class DetermineStudentClassAction extends SubAction
{
    public function run(Student $student, $classId)
    {
        try {
            // Check for existing promotion
            $existingPromotion = DB::table('promoted_class')
                ->where('student_id', $student->id)
                ->where('class_id', $classId)
                ->exists();

            if ($existingPromotion) {
                return ['status' => 'already_exists'];
            }

            // Insert promotion record
            DB::table('promoted_class')->insert([
                'student_id' => $student->id,
                'class_id' => $classId,
            ]);

            return ['status' => 'success'];
        } catch (Exception $e) {
            Log::error('Database error while promoting student: ' . $e->getMessage(), [
                'student_id' => $student->id,
                'class_id' => $classId,
            ]);

            return ['status' => 'error', 'message' => 'Failed to promote student.'];
        }
    }
}
