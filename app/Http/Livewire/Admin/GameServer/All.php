<?php

namespace App\Http\Livewire\Admin\GameServer;

use App\Models\GameServer;
use App\Roles\GameServers;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class All extends Component
{
    use WithPagination;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $game_servers;

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    public function __construct()
    {
        abort_unless(Auth::check(), 401);

        /** @var \App\Models\User */
        $user = Auth::user();
        abort_unless($user->may(GameServers::roleset(), GameServers::VIEW), 401);
    }

    public function mount($gameServers)
    {
        $this->game_servers = $gameServers;
    }

    /**
     * @return array
     */
    public function getListeners(): array
    {
        $listeners = [];

        foreach ($this->game_servers as $game_server)
        {
            $listeners["echo-private:game-servers.{$game_server->uuid},GameServer\\StateChange"] = '$refresh';
            $listeners["echo-private:game-servers.{$game_server->uuid},GameServer\\NewPlaceJob"] = '$refresh';
            $listeners["echo-private:game-servers.{$game_server->uuid},GameServer\\NewThumbnailJob"] = '$refresh';
        }

        return $listeners;
    }

    public function render()
    {
        $servers = paginate($this->game_servers, 15);

        return view('livewire.admin.game-server.all', compact('servers'));
    }
}
