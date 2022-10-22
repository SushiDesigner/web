<?php

namespace App\Events\GameServer;

use App\Enums\ArbiterLogSeverity;
use App\Models\GameServer;
use Illuminate\Support\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class ConsoleOutput implements ShouldBroadcastNow
{
    use Dispatchable;

    /**
     * Creates a new event instance.
     *
     * @param GameServer $game_server
     * @param ArbiterLogSeverity $severity
     * @param Carbon $timestamp
     * @param string $output
     * @param ?string $blur
     */
    public function __construct(
        public GameServer $game_server,
        public ArbiterLogSeverity $severity,
        public Carbon $timestamp,
        public string $output,
        public ?string $blur
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
            'severity' => [
                'event' => $this->severity->event(),
                'color' => (string) $this->severity->color()->toHex()
            ],
            'timestamp' => $this->timestamp->format('n/j/Y g:i:s A'),
            'output' => $this->output,
            'blur' => $this->blur
        ];
    }
}
