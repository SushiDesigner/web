<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecentlyPlayedGames extends Component
{
    public function __construct()
    {
        abort_unless(Auth::check(), 401);
    }

    public function render()
    {
        return view('livewire.dashboard.recently-played-games');
    }
}
