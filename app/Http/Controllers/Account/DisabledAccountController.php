<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DisabledAccountController extends Controller
{
    public function view(Request $request)
    {
        $user = $request->user();

        if (!$user->isBanned())
        {
            return redirect()->route('dashboard');
        }

        $ban = (object) [
            'is_termination' => !$user->ban->is_warning && !$user->ban->is_poison_ban && is_null($user->ban->expiry_date),
            'is_warning' => $user->ban->is_warning,
            'is_poison_ban' => $user->ban->is_poison_ban,
            'reviewed' => $user->ban->created_at->format('m/d/Y h:i:s A (T)'),
            'offensive_item' => $user->ban->offensive_item,
            'moderator_note' => $user->ban->moderator_note,
            'is_appealable' => $user->ban->is_appealable,
        ];

        $ban->expired = false;

        if (!$ban->is_termination && !$ban->is_warning && !$ban->is_poison_ban)
        {
            $ban->duration = seconds2human($user->ban->expiry_date->timestamp - $user->ban->created_at->timestamp, true);
            $ban->expired = $user->ban->expiry_date->isPast();
            $ban->reactivation_date = $user->ban->expiry_date->format('m/d/Y h:i:s A (T)');
        }
        elseif ($ban->is_warning)
        {
            $ban->expired = true;
        }

        return view('auth.account-disabled', compact('ban'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->isBanned())
        {
            return redirect()->route('dashboard');
        }

        if ($user->ban->is_poison_ban || (!$user->ban->is_warning && !$user->ban->is_poison_ban && is_null($user->ban->expiry_date)))
        {
            abort(403);
        }

        if (!$user->ban->is_warning && !$user->ban->expiry_date->isPast())
        {
            abort(403);
        }

        $user->ban->lift();

        return redirect()->route('dashboard')->with('success', __('Welcome back! Please adhere to the :project Terms of Service this time.', ['project' => config('app.name')]));
    }
}
