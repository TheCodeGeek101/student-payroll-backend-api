<?php
namespace App\Containers\UsersSection\Tutors\Actions;

use App\Ship\Actions\Action;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddStudentToClassAction extends Action
{
    public function run(Request $request, Tutor $tutor)
    {
        $student = $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        DB::table('student_tutor')->insert([
            'student_id' => $student['student_id'],
            'tutor_id' => $tutor->id,
        ]);

        return true;
    }
}
