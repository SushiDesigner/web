<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Roles\Users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next)
        {
            if (!$request->user()->may(Users::roleset(), Users::MODERATION_VIEW_USER_PROFILE))
            {
                return abort(404);
            }

            return $next($request);
        });
    }

    public function view()
    {
        return view('admin.user.profile');
    }

    public function load(Request $request)
    {
        $request->validate([
            'username' => ['required', 'exists:users,username']
        ]);

        $user = User::where('username', $request->input('username'))->first();

        return view('admin.user.profile', compact('user'));
    }
}
