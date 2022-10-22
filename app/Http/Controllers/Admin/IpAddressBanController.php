<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Roles\Users;

class IpAddressBanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next)
        {
            if (!$request->user()->may(Users::roleset(), Users::MODERATION_IP_ADDRESS_BAN))
            {
                return abort(404);
            }

            return $next($request);
        });
    }

    public function __invoke()
    {
        return view('admin.user.ip-address-ban');
    }
}
