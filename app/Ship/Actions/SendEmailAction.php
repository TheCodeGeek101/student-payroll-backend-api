<?php


namespace App\Ship\Actions;

use App\Ship\Actions\Action;
use App\Mail\AccountCreationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SendEmailAction extends Action
{
    public function handle(User $user, $password)
    {
        // Prepare the email content
        $details = "Dear {$user->name},\n\n";

        $details .= "We are pleased to inform you that your account has been successfully created. Below are your login credentials:\n\n";

        $details .= "Email: **{$user->email}**\n";   // Highlighted Email
        $details .= "Password: **{$password}**\n\n"; // Highlighted Password

        $details .= "Please note that the password provided is a one-time password (OTP) and must be changed upon your first login for security reasons.\n\n";

        $details .= "To log in to your account, please visit our website and enter your credentials.\n\n";

        $details .= "If you have any questions or need assistance, feel free to contact our support team.\n\n";

        $details .= "Thank you for choosing our services.\n\n";

        $details .= "Best regards,\n";
        $details .= "The Softdroid Solutions Team";

        // Send the email
        Mail::to($user->email)->send(new AccountCreationMail($details));
    }
}
