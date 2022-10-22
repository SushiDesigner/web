<?php

namespace App\Http\Livewire\Admin;

use App\Roles\Users;
use App\Models\Ban;
use App\Models\Action;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ActionLog extends Component
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
        abort_unless($user->isSuperAdmin(), 401);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $logs = Action::search($this->search)->get()->sortByDesc('created_at');

        return view('livewire.admin.action-log')->with('logs', paginate($logs, 15));
    }
}
