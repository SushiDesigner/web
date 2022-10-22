<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class IsBanned
{
    /**
     * Redirects disabled accounts to the account disabled page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $whitelist = [
            'account.disabled',
            'account.unban',
            'document',
            'logout'
        ];

        if (Auth::check())
        {
            if ($request->user()->isBanned() && !in_array(Route::currentRouteName(), $whitelist))
            {
                return redirect()->route('account.disabled');
            }
        }

        return $next($request);
    }
}
