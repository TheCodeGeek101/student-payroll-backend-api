<?php
namespace App\Ship\Actions;

use App\Containers\UsersSection\Admin\Data\Models\Adminstrator;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Ship\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginUserAction extends Action
{
    public function run(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Credentials',
                ], 401);
            }

            $user = Auth::user();
            $userData = null;

            switch ($user->role) {
                case 'superadminstrator':
                    $userData = ['superadmin' => $user];
                    break;
                case 'admin':
                    $userData = ['admin' => $this->getAdministratorData($user->id)];
                    break;
                case 'student':
                    $userData = ['student' => $this->getStudentData($user->id)];
                    break;
                case 'tutor':
                    $userData = ['tutor' => $this->getTutorData($user->id)];
                    break;
            }

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'user' => $userData,
            ], 200);

        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    private function getAdministratorData($userId)
    {
        return Adminstrator::join('users', 'users.id', '=', 'adminstrators.user_id')
            ->where('users.id', $userId)
            ->select('users.*', 'adminstrators.*')
            ->first();
    }

    private function getStudentData($userId)
    {
        return Student::join('users', 'users.id', '=', 'students.user_id')
            ->where('users.id', $userId)
            ->select('users.*', 'students.*')
            ->first();
    }

    private function getTutorData($userId)
    {
        return Tutor::join('users', 'users.id', '=', 'tutors.user_id')
            ->where('users.id', $userId)
            ->select('users.*', 'tutors.*')
            ->first();
    }
}
