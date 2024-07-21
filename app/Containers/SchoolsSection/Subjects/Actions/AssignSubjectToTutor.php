<?php

namespace App\Containers\SchoolsSection\Subjects\Actions;

use App\Containers\UsersSection\Adminstrator\Data\Models\Admin;
use App\Ship\Actions\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
class AssignSubjectToTutor extends Action
{

    public function run(Request $request,Admin $admin, Subject $subject)
    {
        $data = $request->validate([
           'tutor_id' =>  'required|exists:tutors,id',
        ]);
        DB::table('subject_tutor')->insert([
            'subject_id' => $subject->id,
            'tutor_id' => $data['tutor_id'],
            'assigned_by' => $admin->id
        ]);

        return true;
    }
}
