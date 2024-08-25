<?php
namespace App\Containers\UsersSection\Students\Actions;

use App\Jobs\SendEmailJob;
use App\Ship\Actions\Action;
use Illuminate\Support\Facades\DB;
use App\Containers\UsersSection\Students\Data\Models\Student;
use Illuminate\Support\Facades\Hash;
use App\Containers\UsersSection\Students\Requests\StoreStudentRequest;
use App\Models\User;

class CreateStudentAction extends Action
{
    public function run(StoreStudentRequest $request)
    {
        $student = null;
        $user = null;
        $password = 'SecuredKey@2024';

        DB::transaction(function () use ($request, &$student, &$user, &$password) {
            // Extract and format student name
            $student_name = $request->validated()['first_name'] . ' ' . ucfirst($request->validated()['last_name']);

            // Extract admission date and get the year
            $admission_date = $request->validated()['admission_date'];
            $year_of_admission = date('Y', strtotime($admission_date));

            // Retrieve the last registration number generated (if any)
            $last_student = Student::whereYear('admission_date', $year_of_admission)
                ->orderBy('registration_number', 'desc')
                ->first();

            if ($last_student) {
                // Extract the unique identifier from the last registration number
                $last_unique_id = (int) substr($last_student->registration_number, -5);

                // Increment the unique identifier by 1
                $unique_id = str_pad($last_unique_id + 1, 5, '0', STR_PAD_LEFT);
            } else {
                // Start from 00001 if no student exists for the current year
                $unique_id = str_pad(1, 5, '0', STR_PAD_LEFT);
            }

            // Example section code, could be dynamic or based on another logic
            $section_code = 'A01'; // This could be based on the student's class or other factors

            // Generate the registration number
            $registration_number = "SCH-{$year_of_admission}-{$section_code}-{$unique_id}";

            // Create the user record
            $user = User::create([
                'name' => $student_name,
                'email' => $request->validated()['email'],
                'password' => Hash::make($password),
                'role' => 'student',
            ]);

            // Create the student record
            $student = Student::create(array_merge(
                $request->validated(),
                [
                    'user_id' => $user->id,
                    'registered_by' => 1,
                    'registration_number' => $registration_number
                ]
            ));
        });

        // Dispatch email job
        SendEmailJob::dispatch($user, $password)->delay(now()->addMinutes(1));

        return $student;
    }
}
