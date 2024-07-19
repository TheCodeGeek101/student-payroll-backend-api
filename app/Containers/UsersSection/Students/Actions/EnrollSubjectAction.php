<?php

namespace App\Containers\UsersSection\Students\Actions;

use App\Ship\Actions\Action;
use Illuminate\Http\Request;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EnrollSubjectAction extends Action
{
    public function run(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|integer|exists:students,id',
            'subject_id' => 'required|integer|exists:subjects,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data = $validator->validated();

        $student = Student::find($data['student_id']);
        $subject = Subject::find($data['subject_id']);

        if ($student->subjects()->where('subject_id', $data['subject_id'])->exists()) {
            return false;  // Indicate that the student is already enrolled
        }

        $student->subjects()->attach($subject);
        return true;  // Indicate successful enrollment
    }
}
