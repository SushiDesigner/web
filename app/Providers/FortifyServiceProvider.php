<?php

namespace App\Providers;

use App\Models\User;
use Laravel\Fortify\Fortify;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Reads from routes/fortify.php instead
        Fortify::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function (Request $request) {
            // I have no idea if Fortify cares about $request so $request->validate isn't used
            $validator = validator([recaptchaFieldName() => $request->input(recaptchaFieldName())], [recaptchaFieldName() => ['required', recaptchaRuleName()]]);
            if ($validator->fails())
            {
                abort(403);
            }

            $user = User::where('username', $request->input(config('fortify.username')))->first();

            if ($user && Hash::check($request->password, $user->password))
            {
                return $user;
            }
        });

        // Route names      : https://github.com/laravel/fortify/blob/1.x/routes/routes.php
        // Static functions : https://github.com/laravel/fortify/blob/1.x/src/Fortify.php
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.request-password');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        Fortify::twoFactorChallengeView(function () {
            return view('auth.2fa');
        });

        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password');
        });
    }
}
