<?php

namespace App\Http\Livewire\Admin\GameServer;

use App\Roles\GameServers;
use App\Models\GameServer;
use App\Models\Action;
use App\Enums\Actions;
use App\Rules\IsSiprNameOrIpAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Create extends Component
{
    /**
     * @var string
     */
    public $ip_address;

    /**
     * @var integer
     */
    public $maximum_place_jobs;

    /**
     * @var integer
     */
    public $maximum_thumbnail_jobs;

    /**
     * @var integer
     */
    public $port = 64989;

    /**
     * @var mixed
     */
    public $has_vnc = false;

    /**
     * @var ?int
     */
    public $vnc_port = null;

    /**
     * @var ?string
     */
    public $vnc_password = null;

    public function __construct()
    {
        abort_unless(Auth::check(), 401);

        /** @var \App\Models\User */
        $user = Auth::user();
        abort_unless($user->may(GameServers::roleset(), GameServers::CREATE), 401);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'ip_address' => ['required', new IsSiprNameOrIpAddress()], // Rule::unique(GameServer::class)
            'maximum_place_jobs' => ['required', 'integer', 'numeric', 'min:5'],
            'maximum_thumbnail_jobs' => ['required', 'integer', 'numeric', 'min:5'],
            'port' => ['required', 'integer', 'numeric', 'min:0', 'max:65535'],
            'vnc_port' => ['min:0', 'max:65535', 'nullable'],
            'vnc_password' => ['min:0', 'max:512', 'nullable'],
        ];
    }

    public function render()
    {
        return view('livewire.admin.game-server.create');
    }

    public function submit()
    {
        $data = $this->validate();

        if (!is_null(GameServer::whereEncrypted('ip_address', '=', $data['ip_address'])->first()))
        {
            $this->addError('ip_address', __('A game server already exists with that IP address.'));
        }

        if (!isset($data['vnc_port']) && !empty($this->has_vnc))
        {
            $this->addError('vnc_port', __('Please specify a VNC port.'));
        }

        if (!isset($data['vnc_password']) && !empty($this->has_vnc))
        {
            $this->addError('vnc_password', __('Please specify a VNC password.'));
        }

        if (!$this->getErrorBag()->isEmpty())
        {
            return;
        }

        $game_server = GameServer::create(array_filter([
            'uuid' => uuid(),
            'ip_address' => $data['ip_address'],
            'port' => $data['port'],
            'access_key' => GameServer::generateAccessKey(),
            'maximum_place_jobs' => $data['maximum_place_jobs'],
            'maximum_thumbnail_jobs' => $data['maximum_thumbnail_jobs'],
            'has_vnc' => !empty($this->has_vnc),
            'vnc_port' => $data['vnc_port'] ?? null,
            'vnc_password' => $data['vnc_password'] ?? null,
        ], null, ARRAY_FILTER_USE_BOTH));
        Action::log(Request::user(), Actions::CreatedGameServer, $game_server);

        return redirect()->route('admin.game-server.view', $game_server->uuid)->with('success', __('Successfully created game server!'));
    }
}
