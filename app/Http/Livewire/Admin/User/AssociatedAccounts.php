<?php

namespace App\Http\Livewire\Admin\User;

use App\Roles\Users;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AssociatedAccounts extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * @var mixed
     */
    private $accounts;

    public function __construct()
    {
        abort_unless(Auth::check(), 401);

        /** @var \App\Models\User */
        $user = Auth::user();
        abort_unless($user->may(Users::roleset(), Users::MODERATION_VIEW_ASSOCIATED_ACCOUNTS), 401);
    }

    /**
     * @param mixed $accounts
     */
    public function mount(mixed $accounts)
    {
        $this->accounts = $accounts;
    }

    public function render()
    {
        return view('livewire.admin.user.associated-accounts')->with('accounts', $this->accounts->paginate(10));
    }
}
