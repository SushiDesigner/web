<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\PasswordValidationRules;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    use PasswordValidationRules;

    // GET /forgot-password
    public function request()
    {
        return view('auth.request-password');
    }

    // POST /forgot-password
    public function create(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            recaptchaFieldName() => ['required', recaptchaRuleName()]
        ]);

        // Hack, since UserProvider does a traditional ->where and can't search encrypted text
        if (!is_null($user = User::whereEncrypted('email', '=', $request->email)->first()))
        {
            $ciphertext = $user->getRawOriginal('email');
            $this->broker()->sendResetLink(['email' => $ciphertext]);
        }

        return view('auth.request-password')->with('status', __('A password reset link has been sent if the email was valid.'));
    }

    // GET /reset-password/{token}
    public function view(Request $request, $token)
    {
        if (!$request->has('email') || empty($token))
        {
            return abort(404);
        }

        if (!is_null($user = User::whereEncrypted('email', '=', $request->email)->first()))
        {
            if (is_null($rawUser = $this->broker()->getUser(['email' => $user->getRawOriginal('email')])))
            {
                return abort(404);
            }

            if (!$this->broker()->tokenExists($rawUser, $token))
            {
                return abort(404);
            }
        }
        else
        {
            return abort(404);
        }

        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    // POST /reset-password
    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => $this->passwordRules(),
            'password_confirmation' => $this->passwordConfirmationRules()
        ]);

        $ciphertext = '';
        if (!is_null($user = User::whereEncrypted('email', '=', $request->email)->first()))
        {
            $ciphertext = $user->getRawOriginal('email');
        }

        /* $status = */ $this->broker()->reset(
            array_merge($request->only('password', 'password_confirmation', 'token'), ['email' => $ciphertext]),
            function ($user, $password) use ($request) {
                $user->updatePassword($password, $request->ip(), $request->userAgent());
                event(new PasswordReset($user));
            }
        );

        /*
            return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
        */
        // ^^^ Traditionally we would do this, but since we already validated, we can assume that all validation is done.
        // Therefore we just go back to login with "your password has been reset."
        // Otherwise it will say "invalid email" or something; we don't want to expose if actual emails exist or not.

        return redirect()->route('login')->with('status', __('Your password has successfully been reset, <b>:name</b>!', ['name' => $user->username]));
    }

    protected function broker(): mixed
    {
        return Password::broker(config('fortify.passwords'));
    }
}
