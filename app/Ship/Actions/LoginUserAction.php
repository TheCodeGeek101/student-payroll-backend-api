<?php


namespace App\Ship\Actions;

use App\Containers\UsersSection\Adminstrator\Data\Models\Admin;
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

            if ($user->role == 'admin') {
                $userData = Admin::join('users', 'users.id', '=', 'admins.user_id')
                    ->where('users.id', $user->id)
                    ->select('users.*', 'admins.*')
                    ->first();

                $userData = ['admin' => $userData];
            } elseif ($user->role == 'student') {
                $userData = Student::join('users', 'users.id', '=', 'students.user_id')
                    ->where('users.id', $user->id)
                    ->select('users.*', 'students.*')
                    ->first();

                $userData = ['student' => $userData];
            } elseif ($user->role == 'tutor') {
                $userData = Tutor::join('users', 'users.id', '=', 'tutors.user_id')
                    ->where('users.id', $user->id)
                    ->select('users.*', 'tutors.*')
                    ->first();

                $userData = ['tutor' => $userData];
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
}
