<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class DiscordController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('discord')->redirect();
    }

    public function callback(Request $request)
    {
        $request->user()->linkDiscordAccount(Socialite::driver('discord')->user()->id);

        return redirect()->route('account')->with('status', __('Successfully linked Discord account!'));
    }

    public function unlink(Request $request)
    {
        $request->user()->unlinkDiscordAccount();

        return redirect()->route('account')->with('status', __('Your Discord account has been unlinked.'));
    }
}
