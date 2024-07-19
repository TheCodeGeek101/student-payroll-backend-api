<?php

namespace App\Containers\UsersSection\Students\Actions;

use App\Ship\Actions\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EnrollSubjectAction extends Action
{
    public function run(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'subject_id' => 'required|integer|exists:subjects,id',
        ]);
        $subjects = DB::table('student_subject')->insert([
            'student_id' => $data['student_id'],
            'subject_id' => $data['subject_id'],
        ]);
        return $subjects;
    }
}
