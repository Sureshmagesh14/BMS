<?php

namespace App\Providers;
use App\Mail\EmailVerification;
use Illuminate\Support\ServiceProvider;
use View;
use URL;
use Carbon\Carbon;
use Config;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Schema::defaultStringLength(191);
         // Override the email notification for verifying email
         VerifyEmail::toMailUsing(function ($notifiable){        
            $verifyUrl = URL::temporarySignedRoute('verification.verify', \Illuminate\Support\Carbon::now()->addMinutes(\Illuminate\Support\Facades\Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
        return new EmailVerification($verifyUrl, $notifiable);

        });
    }
}
