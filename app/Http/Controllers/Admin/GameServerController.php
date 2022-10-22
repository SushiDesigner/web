<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Roles\GameServers;
use App\Models\GameServer;
use Illuminate\Http\Request;

class GameServerController extends Controller
{
    public function all(Request $request)
    {
        if (!$request->user()->may(GameServers::roleset(), GameServers::VIEW))
        {
            return abort(404);
        }

        return view('admin.game-server.all');
    }

    public function store(Request $request)
    {
        if (!$request->user()->may(GameServers::roleset(), GameServers::CREATE))
        {
            return abort(404);
        }

        return view('admin.game-server.create');
    }

    public function view(Request $request, $id)
    {
        if (!$request->user()->may(GameServers::roleset(), GameServers::VIEW))
        {
            return abort(404);
        }

        $game_server = GameServer::where('uuid', $id)->firstOrFail();
        $data = [
            'isSetUp' => $game_server->is_set_up,
            'uuid' => $game_server->uuid,
            'state' => $game_server->state()->value
        ];

        return view('admin.game-server.view', compact('game_server', 'data'));
    }

    public function manage(Request $request, $id)
    {
        if (!$request->user()->may(GameServers::roleset(), GameServers::MANAGE))
        {
            return abort(404);
        }

        $game_server = GameServer::where('uuid', $id)->firstOrFail();

        return view('admin.game-server.manage', compact('game_server'));
    }

    public function state(Request $request)
    {
        if (!$request->has('uuid'))
        {
            return abort(404);
        }

        $game_server = GameServer::where('uuid', $request->input('uuid'))->firstOrFail();

        return response()->json(['state' => $game_server->state()->value]);
    }

    public function logs(Request $request, $uuid)
    {
        if (!$request->user()->may(GameServers::roleset(), GameServers::CONNECT) || !$request->has('key'))
        {
            return abort(404);
        }

        $game_server = GameServer::where('uuid', $uuid)->firstOrFail();
        $output = [];

        if (!GameServer::$logKeys[$request->input('key')])
        {
            return response()->json(['success' => false]);
        }

        if ($request->input('key') == 'console')
        {
            $trunk = $game_server->retrieveCompleteLog('console');
            unset($trunk['latest']);

            foreach ($trunk as $line)
            {
                $output[] = [
                    'severity' => [
                        'event' => $line[0]->event(),
                        'color' => (string) $line[0]->color()->toHex()
                    ],
                    'timestamp' => $line[1]->format('n/j/Y g:i:s A'),
                    'output' => $line[2],
                    'blur' => $line[3]
                ];
            }

            $trunk = collect($trunk);
            $trunk = $trunk->sortBy(function ($line) {
                return $line[1]->timestamp;
            });

            $output = $trunk->toArray();
        }
        else
        {
            $output = $game_server->retrieveCompleteLog($request->input('key'));
        }

        return response()->json([
            'success' => true,
            'output' => $output
        ]);
    }
}
