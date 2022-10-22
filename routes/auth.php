<?php

use App\Http\Controllers;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers as Fortify;
use Illuminate\Support\Facades\Route;

// Authentication
Route::controller(Fortify\AuthenticatedSessionController::class)->group(function() {
    Route::get('/login', 'create')->middleware(['guest'])->name('login');
    Route::post('/login', 'store')->middleware(['guest', 'throttle:login']);
    Route::post('/logout', 'destroy')->name('logout');
});

// Registration
if (Features::enabled(Features::registration()))
{
    Route::get('/register', [Fortify\RegisteredUserController::class, 'create'])->middleware(['guest'])->name('register');
}

// Password resets
if (Features::enabled(Features::resetPasswords()))
{
    Route::controller(Controllers\Auth\PasswordResetController::class)->middleware(['guest'])->group(function() {
        Route::get('/forgot-password', 'request')->name('password.request');
        Route::post('/forgot-password', 'create')->name('password.email');
        Route::post('/reset-password', 'reset')->middleware(['throttle:5,20'])->name('password.update');
        Route::get('/reset-password/{token}', 'view')->name('password.reset');
    });
}

// Email verification
if (Features::enabled(Features::emailVerification()) && config('app.email_verification'))
{
    Route::middleware(['auth'])->group(function() {
        Route::get('/email/verify', [Fortify\EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [Fortify\VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
        Route::post('/email/verification-notification', Controllers\Auth\EmailVerificationNotificationController::class)->middleware(['throttle:6,1'])->name('verification.send');
    });
}

// Password confirmation
// use by ->middleware('password.confirm')
Route::controller(Fortify\ConfirmablePasswordController::class)->middleware(['auth'])->group(function() {
    Route::get('/user/confirm-password', 'show')->name('password.confirm');
    Route::post('/user/confirm-password', 'store');
});

// Two factor authentication
if (Features::enabled(Features::twoFactorAuthentication()))
{
    Route::controller(Fortify\TwoFactorAuthenticatedSessionController::class)->middleware(['guest'])->group(function() {
        Route::get('/challenge', 'create')->name('two-factor.login');
        Route::post('/challenge', 'store')->middleware(['throttle:two-factor']);
    });

    Route::controller(Fortify\TwoFactorAuthenticationController::class)->middleware(['auth', 'password.confirm'])->group(function() {
        Route::post('/my/security/2fa', 'store')->name('two-factor.enable');
        Route::delete('/my/security/2fa', 'destroy')->name('two-factor.disable');
    });

    Route::middleware(['auth', 'password.confirm'])->group(function() {
        Route::get('/my/security/2fa/qr', [Fortify\TwoFactorQrCodeController::class, 'show'])->name('two-factor.qr-code');

        Route::controller(Fortify\RecoveryCodeController::class)->group(function() {
            Route::get('/my/security/2fa/recovery', 'index')->name('two-factor.recovery-codes');
            Route::post('/my/security/2fa/recovery', 'store');
        });
    });
}
