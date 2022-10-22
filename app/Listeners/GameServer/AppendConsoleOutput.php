<?php

namespace App\Listeners\GameServer;

use App\Events\GameServer\ConsoleOutput;

class AppendConsoleOutput
{
    /**
     * Handle the event.
     *
     * @param  ConsoleOutput  $event
     * @return void
     */
    public function handle(ConsoleOutput $event)
    {
        $event->game_server->appendToLog('console', [$event->severity, $event->timestamp, $event->output, $event->blur]);
    }
}
