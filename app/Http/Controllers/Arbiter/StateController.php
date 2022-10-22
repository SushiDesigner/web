<?php

namespace App\Http\Controllers\Arbiter;

use App\Enums\GameServerState;
use App\Events\GameServer\StateChange;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!$request->has('state'))
        {
            return abort(404);
        }

        if (!$request->game_server->is_set_up)
        {
            $request->game_server->update(['is_set_up' => true]);
        }

        StateChange::dispatch($request->game_server, GameServerState::tryFrom($request->input('state')) ?? GameServerState::Offline);

        return response()->json(['success' => true]);
    }
}
