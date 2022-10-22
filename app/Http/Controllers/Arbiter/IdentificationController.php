<?php

namespace App\Http\Controllers\Arbiter;

use App\Models\GameServer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IdentificationController extends Controller
{
    public function __invoke(Request $request)
    {
        if (empty($request->bearerToken()) || !$request->has('friendly_name') || !$request->has('utc_offset'))
        {
            return abort(404);
        }

        $game_server = GameServer::whereEncrypted('access_key', '=', $request->bearerToken())->firstOrFail();
        $game_server->update(['friendly_name' => $request->input('friendly_name'), 'utc_offset' => $request->input('utc_offset')]);

        return response()->make($game_server->uuid)->header('Content-Type', 'text/plain');
    }
}
