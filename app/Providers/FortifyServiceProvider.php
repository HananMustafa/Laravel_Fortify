<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }
    public function boot(): void
    {

        //REGISTERATION
        Fortify::registerView(function () {
            return view('auth.register');
        });
        //Use the CreateNewUser action class to handle registration
        Fortify::createUsersUsing(\App\Actions\Fortify\CreateNewUser::class);


        //LOGIN AUTHENTICATION
        Fortify::loginView(function () {
            return view('auth.login');
        });


        //FORGOT & RESET PASSWORD
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        //Forgot Password View
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        //Reset Password View
         Fortify::resetPasswordView(function ($request) {
        return view('auth.reset-password', ['request' => $request]);
        });

        
        //EMAIL VERIFICATION
        Fortify::verifyEmailView(function ($request) {
            return view('auth.verify-email');
        });
        
    }
}
