<?php

namespace App\Http\Livewire\Admin\Ban;

use App\Roles\Users;
use App\Models\IpAddressBan;
use App\Models\Action;
use App\Enums\Actions;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PardonIpAddress extends Component
{
    /**
     * @var string
     */
    public $ip_address;

    /**
     * @var string
     */
    public $internal_reason;

    /**
     * @var array
     */
    public $rules = [
        'ip_address' => ['required', 'ipv4'],
    ];

    public function __construct()
    {
        abort_unless(Auth::check(), 401);

        /** @var \App\Models\User */
        $user = Auth::user();
        abort_unless($user->may(Users::roleset(), Users::MODERATION_PARDON_IP_ADDRESS_BAN), 401);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function render()
    {
        return view('livewire.admin.ban.pardon-ip-address');
    }

    public function submit()
    {
        $data = $this->validate();

        if (is_null($ban = IpAddressBan::whereEncrypted('ip_address', '=', $data['ip_address'])->where('is_active', true)->first()))
        {
            return $this->addError('ip_address', __('That IP is not currently banned.'));
        }

        Request::user()->pardonIpAddressBan($ban);
        Action::log(Request::user(), Actions::RemoveIPBan);

        return $this->dispatchBrowserEvent('success', __('Successfully pardoned ban for IP <span class="font-monospace">:ip</span>!', ['ip' => $ban->ip_address]));
    }
}
