<?php

namespace App\Containers\SchoolsSection\Subjects\Actions;

use App\Ship\Actions\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CreateSubjectTutorAction extends Action
{

    public function run(Request $request)
    {
        $data = $request->validate([
           'subject_id' =>  'required|exists:subjects,id',
           'tutor_id' =>  'required|exists:tutors,id',
        ]);
        $assignTutor = DB::table('subject_tutor')->insert([
            'subject_id' => $data['subject_id'],
            'tutor_id' => $data['tutor_id'],
        ]);

        return $assignTutor;
    }
}
