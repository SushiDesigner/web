<?php

namespace App\Http\Livewire\Admin\User;

use App\Roles\Users;
use App\Models\Ban;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ModerationHistory extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * @var \App\Models\User
     */
    private $user;

    /**
     * @param \App\Models\User $user
     */
    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function __construct()
    {
        abort_unless(Auth::check(), 401);

        /** @var \App\Models\User */
        $user = Auth::user();
        abort_unless($user->may(Users::roleset(), Users::MODERATION_VIEW_BAN_HISTORY), 401);
    }

    public function render()
    {
        $bans = Ban::where('user_id', $this->user->id);

        return view('livewire.admin.user.moderation-history')->with('bans', $bans->paginate(15));
    }
}
