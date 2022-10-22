<?php

namespace App\Listeners\GameServer;

use App\Events\GameServer\StateChange;

class ChangeState
{
    /**
     * Handle the event.
     *
     * @param  StateChange  $event
     * @return void
     */
    public function handle(StateChange $event)
    {
        $event->game_server->setState($event->state);
    }
}
