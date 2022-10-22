<?php

namespace App\Events\GameServer;

use App\Models\GameServer;
use App\Models\ThumbnailJob;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class NewThumbnailJob implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    /**
     * Creates a new event instance.
     *
     * @param GameServer $game_server
     * @param ThumbnailJob $job
     */
    public function __construct(
        public GameServer $game_server,
        public ThumbnailJob $job,
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
}
