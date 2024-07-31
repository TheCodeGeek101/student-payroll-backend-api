<?php
namespace App\Containers\SchoolsSection\Subjects\Actions;

use App\Containers\UsersSection\Adminstrator\Data\Models\Admin;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ship\Actions\Action;

class AssignSubjectToTutor extends Action
{
    public function run(Request $request, Admin $admin, Subject $subject)
    {
        $data = $request->validate([
            'tutor_id' => 'required|exists:tutors,id',
        ]);

        try {
            DB::table('subject_tutor')->insert([
                'subject_id' => $subject->id,
                'tutor_id' => $data['tutor_id'],
                'assigned_by' => $admin->id,
            ]);

            return ['status' => 'success'];
        } catch (\Exception $e) {
            \Log::error('Database error: ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Failed to assign subject to tutor'];
        }
    }
}
