<?php

namespace App\Containers\UsersSection\Students\Controllers;

use App\Containers\UsersSection\Students\Actions\UpdateStudentAction;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\UsersSection\Students\Requests\UpdateStudentRequest;
use App\Http\Controllers\Controller;
use App\Containers\UsersSection\Students\Actions\CreateStudentAction;
use App\Containers\UsersSection\Students\Requests\StoreStudentRequest;
use App\Containers\UsersSection\Students\Resources\StudentResource;

class StudentController extends Controller
{
    public function index() {
        $students = Student::all();
        return response()->json($students);
    }

    public function store(StoreStudentRequest $request){
        $student = app(CreateStudentAction::class)->run($request);
        return response()->json([
            'message' => 'Student Created Successfully',
            'student' => $student
        ], 201);
    }

    public function show(Student $student){
        return response()->json(new StudentResource($student));
    }

    public function update(UpdateStudentRequest $request, Student $student){
        $updatedStudent = app(UpdateStudentAction::class)->run($request,$student);
        return response()->json(['message' => 'Student Updated Successfully','student' => $updatedStudent],200);
    }
}
