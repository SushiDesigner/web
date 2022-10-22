<?php

namespace App\Http\Controllers\Admin;

use App\Roles\Users;
use App\Http\Controllers\Controller;

class BanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next)
        {
            if (!$request->user()->may(Users::roleset(), Users::MODERATION_GENERAL_BAN))
            {
                return abort(404);
            }

            return $next($request);
        });
    }

    public function __invoke()
    {
        return view('admin.user.ban');
    }
}
