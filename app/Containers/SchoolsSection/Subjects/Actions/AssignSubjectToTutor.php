<?php
namespace App\Containers\SchoolsSection\Subjects\Actions;

use App\Containers\UsersSection\Admin\Data\Models\Adminstrator;
use App\Containers\UsersSection\Adminstrator\Data\Models\Admin;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ship\Actions\Action;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AssignSubjectToTutor extends Action
{
    public function run(Request $request, Adminstrator $admin, Subject $subject)
    {
        $data = $request->validate([
            'tutor_id' => 'required|exists:tutors,id',
        ]);

        // Check if the tutor is already assigned to the subject
        $existingAssignment = DB::table('subject_tutor')
            ->where('subject_id', $subject->id)
            ->where('tutor_id', $data['tutor_id'])
            ->exists();

        if ($existingAssignment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tutor already assigned to this subject',
            ], Response::HTTP_CONFLICT); // 429 Conflict
        }

        try {
            DB::table('subject_tutor')->insert([
                'subject_id' => $subject->id,
                'tutor_id' => $data['tutor_id'],
                'assigned_by' => $admin->id,
            ]);

            return ['status' => 'success'];
        } catch (\Exception $e) {
            Log::error('Database error: ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Failed to assign subject to tutor'];
        }
    }
}
