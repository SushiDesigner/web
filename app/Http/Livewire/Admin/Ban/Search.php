<?php

namespace App\Http\Livewire\Admin\Ban;

use App\Roles\Users;
use App\Models\Ban;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    /**
     * @var string
     */
    public $search = '';

    /**
     * @var array
     */
    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function __construct()
    {
        abort_unless(Auth::check(), 401);

        /** @var \App\Models\User */
        $user = Auth::user();
        abort_unless($user->may(Users::roleset(), Users::MODERATION_VIEW_BAN_LIST), 401);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $bans = Ban::search($this->search)->get();

        $this->dispatchBrowserEvent('admin-hook-details');

        return view('livewire.admin.ban.search')->with('bans', paginate($bans, 15));
    }
}
