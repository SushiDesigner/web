<?php

namespace App\Http\Livewire\Admin\Ban;

use App\Roles\Users;
use App\Models\IpAddressBan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class IpAddressSearch extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    /**
     * @var string
     */
    public $search = '';

    public function __construct()
    {
        abort_unless(Auth::check(), 401);

        /** @var \App\Models\User */
        $user = Auth::user();
        abort_unless($user->may(Users::roleset(), Users::MODERATION_VIEW_IP_ADDRESS_BAN_LIST), 401);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (empty(trim($this->search)))
        {
            $bans = IpAddressBan::orderBy('created_at', 'DESC');
        }
        else
        {
            $bans = IpAddressBan::whereEncrypted('ip_address', '=', $this->search);
        }

        return view('livewire.admin.ban.ip-address-search')->with('bans', paginate($bans->get(), 15));
    }
}
