<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\GameServer;

class AuthenticateArbiter
{
    /**
     * Blocks unallowed access to arbiter routes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty($request->bearerToken()))
        {
            return abort(404);
        }

        $game_server = GameServer::whereEncrypted('access_key', '=', $request->bearerToken())->firstOrFail();
        $request->merge(compact('game_server'));

        return $next($request);
    }
}
