<?php

namespace App\Enums;

enum GameServerState : int
{
    /**
     * The game server is online and is ready to receive job operations.
     */
    case Online = 0;

    /**
     * The game server is offline and is unable to receive any operations.
     */
    case Offline = 1;

    /**
     * The game server has crashed.
     */
    case Crashed = 2;

    /**
     * The game server is online, but does not want to receive job operations.
     */
    case Paused = 3;
}
