<?php

namespace App\Otp;

use SadiqSalau\LaravelOtp\Contracts\OtpInterface as Otp;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use SadiqSalau\LaravelOtp\Facades\Otp as OtpFacade;

class AuthenticateUserOtp implements Otp
{
    /**
     * @var string $email
     */
    public string $email;

    /**
     * @var string|null $otp
     */
    public ?string $otp;

    /**
     * Constructor for AuthenticateUserOtp.
     *
     * @param string $email The email to associate with the OTP.
     * @param string|null $otp The OTP code entered by the user.
     */
    public function __construct(string $email, ?string $otp = null)
    {
        $this->email = $email;
        $this->otp = $otp;
    }

    /**
     * Processes OTP verification
     *
     * This method will verify the OTP and if valid, log in the user.
     *
     * @return mixed
     */
    public function process()
    {
        // Check if the OTP is provided and valid
        if ($this->otp) {
            $otpStatus = OtpFacade::identifier($this->email)->attempt($this->otp);

            if ($otpStatus['status'] === OtpFacade::OTP_VERIFIED) {
                $user = User::where('email', $this->email)->first();

                if ($user) {
                    Auth::login($user);
                    return $user;
                }
            }
        }

        // Log failure for debugging
        Log::error('OTP verification failed for email: ' . $this->email);
        return false;
    }

}
