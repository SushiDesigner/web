<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Roles\Users;
use App\Models\InviteKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InviteKeyController extends Controller
{
    private function mayPurchaseKey()
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        if (!$user->may(Users::roleset(), Users::PURCHASE_INVITE_KEY))
        {
            return __('You may not purchase an invite key.');
        }

        if (!$user->hasEnoughMoney(config('tadah.user_invite_key_cost')))
        {
            return __('You do not have enough :currency to purchase an invite key.', ['currency' => config('tadah.currency_name')]);
        }

        if (!$user->hasLinkedDiscordAccount() && config('tadah.discord_required'))
        {
            return __('Please link your Discord account in order to create invite keys.');
        }

        $our_keys = InviteKey::where('creator_id', $user->id)
            ->where('created_at', '>', now()->subDays(config('tadah.user_invite_key_cooldown'))->endOfDay())
            ->get();

        if (count($our_keys) >= config('tadah.user_maximum_keys_in_window'))
        {
            return __("You've already made :maximum invite keys in the past :cooldown days.", ['maximum' => config('tadah.user_maximum_keys_in_window'), 'cooldown' => config('app.user_invite_key_cooldown')]);
        }

        return true;
    }

    public function view(Request $request)
    {
        $keys = InviteKey::where('creator_id', $request->user()->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(15);
        $disabled = $this->mayPurchaseKey() !== true;

        return view('my.invites', compact('keys', 'disabled'));
    }

    public function purchase(Request $request)
    {
        $user = $request->user();

        if (($reason = $this->mayPurchaseKey()) !== true)
        {
            return back()->with('error', $reason);
        }

        $user->spend(config('tadah.user_invite_key_cost'), 'Bought invite key');

        InviteKey::generate($user->id, 1);

        return back()->with('success', __('New invite key created.'));
    }
}
