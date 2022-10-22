<?php

namespace App\Http\Livewire\Admin\Ban;

use App\Roles\Users;
use App\Models\User;
use App\Models\IpAddressBan;
use App\Models\Action;
use App\Enums\Actions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Illuminate\Support\Str;

class IpAddress extends Component
{
    /**
     * @var string
     */
    public $identifier;

    /**
     * @var string
     */
    public $internal_reason;

    /**
     * @var array
     */
    public $rules = [
        'identifier' => ['required', 'max:255'],
        'internal_reason' => ['max:255'],
    ];

    public function __construct()
    {
        abort_unless(Auth::check(), 401);

        /** @var \App\Models\User */
        $user = Auth::user();
        abort_unless($user->may(Users::roleset(), Users::MODERATION_IP_ADDRESS_BAN), 401);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function render()
    {
        return view('livewire.admin.ban.ip-address');
    }

    public function submit()
    {
        $data = $this->validate();
        $to_ban = [];

        /**
         * Identifier whereabout check;
         *
         * 1. First check if the identifier is a e-mail address by seeing if it contains an '@' character in it. Get the IPs of the users that have this e-mail address and add them to $to_ban.
         * 2. If the identifier wasn't an e-mail address, we proceed to check if it is an IPv6 address, by seeing if it contains a period. If it does, return an error.
         * 3. If it wasn't an IPv6 address, then we check to see if it is a username (by seeing if it is alphanumeric and less than 20 characters.) If it matches this check but no users exist, we boot them out. We add the IPs of the user to the $to_ban array.
         * 4. If it wasn't a username, check if it's an IPv4. If it isn't, boot them out. If it is, add it to $to_ban.
         */

        if (Str::contains($data['identifier'], '@'))
        {
            if (is_null($users = User::whereEncrypted('email', '=', $data['identifier'])->get()))
            {
                return $this->addError('identifier', __('No users exist with this e-mail address.'));
            }

            foreach ($users as $user)
            {
                if ($user->isSuperAdmin())
                {
                    return $this->addError('identifier', __('No users exist with that username.'));
                }

                $to_ban[] = $user->register_ip;
                $to_ban[] = $user->last_ip;
            }
        }
        elseif (Str::contains($data['identifier'], ':'))
        {
            return $this->addError('identifier', __('IPv6 addresses are not supported.'));
        }
        elseif (ctype_alnum($data['identifier']))
        {
            if (is_null($user = User::where('username', $data['identifier'])->first()) )
            {
                return $this->addError('identifier', __('No users exist with that username.'));
            }

            if ($user->isSuperAdmin())
            {
                return $this->addError('identifier', __('You may not ban superadmins.'));
            }

            $to_ban[] = $user->register_ip;
            $to_ban[] = $user->last_ip;
        }
        else
        {
            if (!filter_var($data['identifier'], FILTER_VALIDATE_IP))
            {
                return $this->addError('identifier', __('Please enter a valid IPv4 address.'));
            }

            $to_ban[] = $data['identifier'];
        }

        $to_ban = array_unique($to_ban);

        if (in_array(Request::ip(), $to_ban))
        {
            return $this->dispatchBrowserEvent('error', __('You cannot ban yourself.'));
        }

        $count = 0;

        foreach ($to_ban as $banned_ip)
        {
            if (!is_null($existing = IpAddressBan::whereEncrypted('ip_address', '=', $banned_ip)->first()))
            {
                if ($existing->is_active)
                {
                    continue;
                }
            }

            $count++;

            IpAddressBan::create(array_filter([
                'ip_address' => $banned_ip,
                'moderator_id' => Request::user()->id,
                'internal_reason' => $data['internal_reason'],
                'criterium' => $data['identifier']
            ], null, ARRAY_FILTER_USE_BOTH));
            Action::log(Request::user(), Actions::AddIPBan);
        }

        return $this->dispatchBrowserEvent('success', __(':amount IP(s) have been banned. Please check the ban list to see who got affected.', ['amount' => number_format($count)]));
    }
}
