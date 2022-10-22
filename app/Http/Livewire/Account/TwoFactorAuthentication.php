<?php

namespace App\Http\Livewire\Account;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TwoFactorAuthentication extends Component
{
    public function __construct()
    {
        abort_unless(Auth::check(), 401);
    }

    public function render()
    {
        return view('livewire.account.two-factor-authentication');
    }

    public function enable()
    {
        
    }

    public function disable()
    {
        
    }

    public function confirm()
    {
        
    }
}
