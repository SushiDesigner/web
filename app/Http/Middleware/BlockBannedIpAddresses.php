<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class BlockBannedIpAddresses
{
    /**
     * Blocks banned IP addresses from accessing the website.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!app()->environment('production'))
        {
            return $next($request);
        }

        if (in_array($request->ip(), Cache::store('octane')->get('banned_ip_addresses') ?? []))
        {
            return response()->make('Access Denied', 403);
        }

        return $next($request);
    }
}
