<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Reset Password') }}</title>
</head>
<body>
    <h2>{{ __('Reset Password Notification') }}</h2>

    <p>{{ __('You are receiving this email because we received a password reset request for your account.') }}</p>
    <p>
        {{ __('Click the button below to reset your password:') }}
    </p>
    <p>
        <a href="{{ $resetUrl }}" style="background-color: #3490dc; color: #ffffff; display: inline-block; padding: 10px 20px; text-decoration: none; border-radius: 5px;">{{ __('Reset Password') }}</a>
    </p>
    <p>{{ __('If you did not request a password reset, no further action is required.') }}</p>
    <p>{{ __('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]) }}</p>
</body>
</html>
