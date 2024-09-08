<?php
namespace App\Containers\UsersSection\Students\Actions;

use App\Ship\Actions\Action;
use Illuminate\Http\Request;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;

class EnrollSubjectAction extends Action
{
    public function run(Request $request, Student $student)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|integer|exists:subjects,id',
            'class_id' => 'required|integer|exists:classroom,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data = $validator->validated();

        // Retrieve the Student, Subject, and Class models
        $subject = Subject::findOrFail($data['subject_id']);
        $class = ClassModel::findOrFail($data['class_id']);

        // Check if the student is already enrolled in the subject
          if ($student->subjects()->where('subject_id', $data['subject_id'])->exists()) {
            return false;  // Indicate that the student is already enrolled
        }

        // Attach the subject and class to the student in the pivot table
        $student->subjects()->attach($subject->id, [
            'class_id' => $class->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Student successfully enrolled'], 200);
    }
}
