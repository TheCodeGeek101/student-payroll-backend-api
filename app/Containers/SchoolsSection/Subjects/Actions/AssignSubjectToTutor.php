<?php

namespace App\Containers\SchoolsSection\Subjects\Actions;

use App\Containers\UsersSection\Adminstrator\Data\Models\Admin;
use App\Ship\Actions\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AssignSubjectToTutor extends Action
{

    public function run(Request $request,Admin $admin)
    {
        $data = $request->validate([
           'subject_id' =>  'required|exists:subjects,id',
           'tutor_id' =>  'required|exists:tutors,id',
        ]);
        $assignSubject = DB::table('subject_tutor')->insert([
            'subject_id' => $data['subject_id'],
            'tutor_id' => $data['tutor_id'],
            'assigned_by' => $admin->id
        ]);

        return $assignSubject;
    }
}
