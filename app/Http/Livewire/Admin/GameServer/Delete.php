<?php

namespace App\Http\Livewire\Admin\GameServer;

use App\Models\GameServer;
use App\Roles\GameServers;
use App\Models\Action;
use App\Enums\Actions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Delete extends Component
{
    /**
     * @var GameServer
     */
    public $gameServer;

    /**
     * @param GameServer $gameServer
     */
    public function mount($gameServer)
    {
        $this->gameServer = $gameServer;
    }

    public function __construct()
    {
        abort_unless(Auth::check(), 401);

        /** @var \App\Models\User */
        $user = Auth::user();
        abort_unless($user->may(GameServers::roleset(), GameServers::MANAGE), 401);
    }

    public function render()
    {
        return view('livewire.admin.game-server.delete');
    }

    public function submit()
    {
        $this->gameServer->delete();
        Action::log(Request::user(), Actions::DeletedGameServer, $this->gameServer);

        return redirect()->route('admin.game-server.all')->with('success', __('Successfully deleted game server!'));
    }
}
