<?php

namespace App\Ship\Controllers;

use App\Http\Controllers\Controller;
use App\Ship\Actions\LoginUserAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpSendEmail;
use Exception;
use App\Http\Requests\VerifyOtpRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request): JsonResponse
    {
        $action = app(LoginUserAction::class);
        $response = $action->run($request);

        if (!$response->original['status']) {
            if ($response->getStatusCode() === 403) {
                return response()->json([
                    'status' => false,
                    'message' => 'User is forbidden from accessing the system (withdrawn student)',
                ], 403);
            }
            return $response;
        }

        $user = Auth::user();
        $token = $user->createToken('API TOKEN')->plainTextToken;
        if (!$token) {
            return response()->json(['status' => false, 'message' => 'Failed to create authentication token.'], 500);
        }

        $code = random_int(100000, 999999);
        $Otp  = User::where('id', Auth::user()->id)->update([
            'two_factor_code' => $code,
        ]);

        $details = "Dear {$user->name},\n\nHere is your verification code: $code";

        try {
            Mail::to($user->email)->send(new OtpSendEmail($details));
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to send OTP email. Please try again later.',
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'user' => $response->original['user'],
            'token' => $token,
        ], 200);
    }

     public function verifyOtp(VerifyOtpRequest $request): JsonResponse
     {
        $user = Auth::user();

        $loggedInUser = User::where('id','=',$user->id)->first();
        \Log::warning('User Id', [
            'user_id' => $user->id,
            // 'attempted_code' => $request->validated()['two_factor_code']
        ]);

        // Ensure OTP exists
        if (!$loggedInUser->two_factor_code) {
            return response()->json([
                'status' => false,
                'message' => 'OTP verification failed.'
            ], 400);
        }

        // Check OTP expiration
        if ($loggedInUser->otp_expires_at && now()->greaterThan($loggedInUser->otp_expires_at)) {
            return response()->json([
                'status' => false,
                'message' => 'The OTP has expired. Please request a new one.'
            ], 400);
        }

        // Match OTP from request with the stored OTP
        if ($request->validated()['two_factor_code'] === $loggedInUser->two_factor_code) {
            // Clear the OTP after successful verification
            $loggedInUser->two_factor_code = null;
            $loggedInUser->otp_expires_at = null; // Clear expiration
            $loggedInUser->save();

            event(new OtpVerificationSuccessful($loggedInUser));

            return response()->json([
                'status' => true,
                'message' => 'Verification successful. User authenticated successfully.'
            ], 200);
        }

        // Log and fire event for failed attempts
        \Log::warning('OTP verification failed', [
            'user_id' => $user->id,
            'attempted_code' => $request->validated()['two_factor_code']
        ]);

        event(new OtpVerificationFailed($user, $request->validated()['two_factor_code']));

        return response()->json([
            'status' => false,
            'message' => 'Invalid verification code.'
        ], 401);
     }



    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => true,
            'message' => 'User Logged Out Successfully'
        ], 200);
    }
}
