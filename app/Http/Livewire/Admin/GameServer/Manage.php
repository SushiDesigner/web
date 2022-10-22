<?php

namespace App\Http\Livewire\Admin\GameServer;

use App\Roles\GameServers;
use App\Rules\IsSiprNameOrIpAddress;
use App\Models\GameServer;
use App\Models\Action;
use App\Enums\Actions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Manage extends Component
{
    /**
     * @var GameServer
     */
    public $gameServer;

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
    public $has_vnc = true;

    /**
     * @var ?int
     */
    public $vnc_port = null;

    /**
     * @var ?string
     */
    public $vnc_password = null;

    /**
     * @param GameServer $gameServer
     */
    public function mount($gameServer)
    {
        $this->gameServer = $gameServer;

        $this->ip_address = $this->gameServer->ip_address;
        $this->maximum_place_jobs = $this->gameServer->maximum_place_jobs;
        $this->maximum_thumbnail_jobs = $this->gameServer->maximum_thumbnail_jobs;
        $this->port = $this->gameServer->port;
        $this->has_vnc = $this->gameServer->has_vnc;
        $this->vnc_port = $this->gameServer->vnc_port;
        $this->vnc_password = $this->gameServer->vnc_password;
    }

    public function updated($property)
    {
        $this->validateOnly($property);
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
        return view('livewire.admin.game-server.manage');
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

    public function submit()
    {
        $data = $this->validate();

        if (is_null($server = GameServer::whereEncrypted('ip_address', '=', $data['ip_address'])->first()))
        {
            if (!$server->is($this->gameServer))
            {
                $this->addError('ip_address', __('A game server already exists with that IP address.'));
            }
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

        $this->gameServer->update(array_filter([
            'ip_address' => $this->ip_address,
            'maximum_place_jobs' => $this->maximum_place_jobs,
            'maximum_thumbnail_jobs' => $this->maximum_thumbnail_jobs,
            'port' => $this->port,
            'has_vnc' => $this->has_vnc,
            'vnc_port' => $data['vnc_port'] ?? null,
            'vnc_password' => $data['vnc_password'] ?? null,
        ], null, ARRAY_FILTER_USE_BOTH));
        Action::log(Request::user(), Actions::ModifiedGameServer, $this->gameServer);

        return $this->dispatchBrowserEvent('success', __('Successfully updated game server!'));
    }
}
