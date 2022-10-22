<?php

namespace App\Http\Controllers\Arbiter;

use App\Http\Controllers\Controller;
use App\Events\GameServer\ConsoleOutput;
use App\Events\GameServer\ResourceReport;
use App\Enums\ArbiterLogSeverity;
use App\Models\GameServer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LogController extends Controller
{
    public function log(Request $request, $uuid)
    {
        if (!$request->has('severity') || !$request->has('timestamp') || !$request->has('output') || !$request->has('blur'))
        {
            return abort(404);
        }

        $game_server = GameServer::where('uuid', $uuid)->firstOrFail();

        if (!$game_server->is($request->game_server))
        {
            return abort(404);
        }

        ConsoleOutput::dispatch($game_server,
            ArbiterLogSeverity::tryFrom($request->input('severity')) ?? null,
            Carbon::createFromTimestamp($request->input('timestamp'))->setTimezone($game_server->utc_offset),
            $request->input('output'),
            $request->input('blur')
        );

        return response()->json(['success' => true]);
    }

    public function resources(Request $request, $uuid)
    {
        if (!$request->has('cpu') || !$request->has('ram') || !$request->has('inbound') || !$request->has('outbound'))
        {
            return abort(404);
        }

        $game_server = GameServer::where('uuid', $uuid)->firstOrFail();

        if (!$game_server->is($request->game_server))
        {
            return abort(404);
        }

        ResourceReport::dispatch($game_server, (object) [
            'cpu' => $request->input('cpu'),
            'ram' => $request->input('ram'),
            'net' => [
                'in' => $request->input('inbound'),
                'out' => $request->input('outbound')
            ]
        ]);

        return response()->json(['success' => true]);
    }
}
