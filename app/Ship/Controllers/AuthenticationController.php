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

        if (!$response->original['status']) {
            return $response;
        }

        $user = Auth::user(); // Retrieve the authenticated user
        $token = $user->createToken('API TOKEN')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['status' => true, 'message' => 'User Logged Out Successfully'],200);
    }
}
