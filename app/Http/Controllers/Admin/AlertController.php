<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AlertController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next)
        {
            if (!$request->user()->isSuperAdmin())
            {
                return abort(404);
            }

            return $next($request);
        });
    }

    public function __invoke()
    {
        return view('admin.alert');
    }
}
