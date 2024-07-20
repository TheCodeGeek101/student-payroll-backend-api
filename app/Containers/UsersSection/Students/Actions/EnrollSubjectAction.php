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
    public function run(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|integer|exists:subjects,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data = $validator->validated();

        $student = Student::find($student->id);
        $subject = Subject::find($data['subject_id']);

        if ($student->subjects()->where('subject_id', $data['subject_id'])->exists()) {
            return false;  // Indicate that the student is already enrolled
        }

        $student->subjects()->attach($subject);
        return true;  // Indicate successful enrollment
    }
}
