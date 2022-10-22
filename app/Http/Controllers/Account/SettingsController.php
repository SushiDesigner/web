<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Rules\IsCurrentPassword;
use App\Traits\EmailValidationRules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    use EmailValidationRules;

    public function view(Request $request)
    {
        $current_session = null;
        $sessions = [];

        DB::table('sessions')->where('user_id', $request->user()->id)->get()->each(function ($session) use ($request, &$sessions, &$current_session) {
            if ($session->id == $request->session()->getId())
            {
                $current_session = (object) [
                    'agent' => agent($session->user_agent),
                    'location' => geolocate($session->ip_address),
                    'last_ping' => time(),
                    'ip' => $session->ip_address,
                ];

                return;
            }

            $sessions[] = (object) [
                'key' => encrypt($session->id),
                'agent' => agent($session->user_agent),
                'location' => geolocate($session->ip_address),
                'last_ping' => $session->last_activity,
                'ip' => $session->ip_address,
            ];
        });

        return view('my.account', [
            'current_session' => $current_session,
            'sessions' => $sessions,
            'discord_user' => $request->user()->discordAccount(),
        ]);
    }

    public function updateEmail(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $user = $request->user();

            $data = $request->validate([
                'email' => $this->emailRules(),
                'current_password' => ['required', new IsCurrentPassword($user)],
            ]);

            $user->updateEmail($data['email'], $request->ip(), $request->userAgent());

            return redirect()->route('account')->with('status', __('Your E-Mail address has been succesfully updated!'));
        }

        return view('auth.update-email');
    }

    public function heartbeat(Request $request)
    {
        $user = $request->user();

        $activity = $user->activity;
        $activity['website'] = time();

        $user->update(compact('activity'));

        return response()->json(['success' => true]);
    }
}
