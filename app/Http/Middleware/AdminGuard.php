<?php

namespace App\Http\Middleware;

use Closure;
use App\Roles\Admin;
use Illuminate\Http\Request;

class AdminGuard
{
    /**
     * Blocks unallowed access to admin routes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->may(Admin::roleset(), Admin::VIEW_PANEL))
        {
            return abort(404);
        }

        return $next($request);
    }
}
