<?php

namespace App\Events\GameServer;

use App\Models\GameServer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class ResourceReport implements ShouldBroadcastNow
{
    use Dispatchable;

    /**
     * Creates a new event instance.
     *
     * @param GameServer $game_server
     * @param object $resources
     */
    public function __construct(
        public GameServer $game_server,
        public object $resources,
    ) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn(): Channel|array
    {
        return new PrivateChannel('game-servers.' . $this->game_server->uuid);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return (array) $this->resources;
    }
}
