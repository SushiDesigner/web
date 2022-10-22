<?php

namespace App\Events\GameServer;

use App\Models\GameServer;
use App\Enums\GameServerState;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class StateChange implements ShouldBroadcastNow
{
    use Dispatchable;

    /**
     * Creates a new event instance.
     *
     * @param GameServer $game_server
     * @param GameServerState $state
     */
    public function __construct(
        public GameServer $game_server,
        public GameServerState $state,
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
        return [
            'state' => $this->state->value,
            'utc_offset' => $this->game_server->utc_offset,
            'friendly_name' => $this->game_server->friendly_name
        ];
    }
}
