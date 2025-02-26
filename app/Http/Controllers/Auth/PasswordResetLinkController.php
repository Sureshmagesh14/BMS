<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Models\Respondents;
use App\Mail\ResetPasswordEmail;
use App\Models\PasswordResetsViaPhone;
use Exception;
use App\Services\SendGridService;
class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);
    
        // Find the user by email
        $user = Respondents::where('email', $request->email)->first();
    
        // Check if the user exists
        if (!$user) {
            return back()->withErrors(['email' => __('We could not find a user with that email address.')]);
        }
    
        try {
            // Generate password reset token
            $token = Password::getRepository()->create($user);
    
            // Generate password reset URL (without expiration)
            $resetUrl = URL::route('password.reset', ['token' => $token, 'email' => $user->email]);
    
            // Prepare dynamic data for SendGrid
            $dynamicData = [
                'first_name' => $user->name,
                'type' => 'forgot_password_email',
                'token' => $token,
                'reset_link' => $resetUrl,
            ];
    
            // Send the email using SendGrid service
            $subject = 'Reset Password Notification';
            $templateId = 'd-a30f8f4af1e34e0da5dc3f6b7e036743'; // Replace this with your actual SendGrid template ID
    
            $sendgrid = new SendGridService();
            $sendgrid->setFrom();
            $sendgrid->setSubject($subject);
            $sendgrid->setTemplateId($templateId);
            $sendgrid->setDynamicData($dynamicData);
            $sendgrid->setToEmail($user->email, $user->name);
            $sendgrid->send();
    
            // If everything goes well, return success response
            return back()->with('status', __('Password reset email sent! Please check your email.'));
        
        } catch (\Exception $e) {
            // Log the exception and return error message
            \Log::error('Failed to send password reset email: ' . $e->getMessage());
            return back()->withErrors(['email' => __('Failed to send password reset email. Please try again later.')]);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
          
            'password' => 'required|min:6|confirmed',
            'token' => 'required|string',
        ]);

        try {
            // Validate the token
            $resetRecord = PasswordResetsViaPhone::where('token', $request->token)
                // ->where('updated_at', '>', now())
                ->first();

            if (!$resetRecord) {
                return redirect()->back()->with('error', 'Invalid or expired token.');
            }

            // Find the user
            $user = Respondents::where('mobile', $request->mobile)->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Mobile number not found.');
            }

            // Update the user's password
            $user->password = bcrypt($request->password);
            $user->save();

            // Delete the reset record
            $resetRecord->delete();

            return redirect()->route('login')->with('status', 'Password reset successfully. You can now log in.');

        } catch (Exception $e) {
            Log::error('Password reset failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to reset password. ' . $e->getMessage());
        }
    }

    public function showResetForm(Request $request){
        return view('admin.admin-reset');
    }
    
}
