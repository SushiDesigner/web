<?php

namespace App\Listeners\GameServer;

use App\Events\GameServer\ResourceReport;

class Ping
{
    /**
     * Handle the event.
     *
     * @param  ResourceReport  $event
     * @return void
     */
    public function handle(ResourceReport $event)
    {
        $event->game_server->ping();
    }
}
