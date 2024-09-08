<?php

namespace App\Ship\Controllers;

use App\Http\Controllers\Controller;
use App\Ship\Actions\LoginUserAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $action = app(LoginUserAction::class);
        $response = $action->run($request);

        // Check for a forbidden response (403) or any other failure
        if (!$response->original['status']) {
            // If the status code is 403 (forbidden), return that response
            if ($response->getStatusCode() === 403) {
                return response()->json([
                    'status' => false,
                    'message' => 'User is forbidden from accessing the system (withdrawn student)',
                ], 403);
            }
            
            // Otherwise, return the error as is (could be validation error or invalid credentials)
            return $response;
        }

        // If login was successful, create a token and return user data
        $user = Auth::user(); // Retrieve the authenticated user
        $token = $user->createToken('API TOKEN')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'user' => $response->original['user'],
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['status' => true, 'message' => 'User Logged Out Successfully'], 200);
    }
}
