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
    
        $user = Respondents::where('email', $request->email)->first();
    
        if (!$user) {
            return back()->withErrors(['email' => __('We could not find a user with that email address.')]);
        }
    
        // Generate password reset token
        $token = Password::getRepository()->create($user);
    
        // Generate password reset URL
        $resetUrl = URL::temporarySignedRoute(
            'password.reset', now()->addMinutes(60), ['token' => $token, 'email' => $user->email]
        );

        
    
        try {
            // Send password reset email
            $data = [
                'subject' => 'Reset Password Notification',
                'type' => 'forgot_password_email',
                'token' => $token,
                'resetUrl' => $resetUrl,
            ];
    
            Mail::to($user->email)->send(new ResetPasswordEmail($data));
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Log the exception for debugging
            \Log::error('Failed to send password reset email: ' . $e->getMessage());
            return back()->withErrors(['email' => __('Failed to send password reset email. Please try again later.')]);
        }
    
        return back()->with('status', __('Password reset email sent! Please check your email.'));
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
