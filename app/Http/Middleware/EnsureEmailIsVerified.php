<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
{
    /**
     * Redirects non verified users to the email verification page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!config('app.email_verification'))
        {
            return $next($request);
        }

        $whitelisted = [
            'logout',
            'verification.notice',
            'verification.verify',
            'verification.send',
        ];

        if (in_array($request->route()->getName(), $whitelisted))
        {
            return $next($request);
        }

        if ($request->user() && !$request->user()->hasVerifiedEmail())
        {
            return $request->expectsJson() ? abort(403, 'Your email address is not verified.') : redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
