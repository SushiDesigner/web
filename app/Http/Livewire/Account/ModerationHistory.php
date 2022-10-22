<?php

namespace App\Http\Livewire\Account;

use App\Models\Ban;
use App\Roles\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithPagination;

class ModerationHistory extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    public function __construct()
    {
        abort_unless(Auth::check(), 401);

        /** @var \App\Models\User */
        $user = Auth::user();
        abort_unless($user->may(Users::roleset(), Users::VIEW_BAN_HISTORY), 401);
    }

    public function render()
    {
        $user = Auth::user();

        $bans = Ban::where('user_id', $user->id)->get();
        $bans = paginate($bans, 15);

        return view('livewire.account.moderation-history', [
            'bans' => $bans
        ]);
    }
}
