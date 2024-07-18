<?php
namespace App\Containers\UsersSection\Students\Actions;

use App\Ship\Actions\Action;
use Illuminate\Support\Facades\DB;
use App\Containers\UsersSection\Students\Data\Models\Student;
use Illuminate\Support\Facades\Hash;
use App\Containers\UsersSection\Students\Requests\StoreStudentRequest;
use App\Models\User;

class CreateStudentAction extends Action{
    public function run(StoreStudentRequest $request) {
        $student = null;
        DB::transaction(function () use ($request, &$student) {
            $student_name = $request->validated()['first_name'] . ' ' . ucfirst($request->validated()['last_name']);

            $user = User::create([
                'name' => $student_name,
                'email' => $request->validated()['email'],
                'password' => Hash::make('SecuredKey@2024'),
                'role' => 'student',
            ]);

            $student = Student::create(array_merge(
                $request->validated(),
                ['user_id' => $user->id, 'registered_by' => 1]
            ));
        });
        return $student;
    }
}
