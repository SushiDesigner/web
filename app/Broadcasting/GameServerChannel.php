<?php

namespace App\Broadcasting;

use App\Roles\GameServers;
use App\Models\User;
use App\Models\GameServer;

class GameServerChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User       $user
     * @param  \App\Models\GameServer $game_server
     * @return array|bool
     */
    public function join($user, $game_server)
    {
        return $user->may(GameServers::roleset(), GameServers::CONNECT);
    }
}
