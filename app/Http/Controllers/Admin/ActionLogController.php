<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActionLogController extends Controller
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

    public function view()
    {
        return view('admin.action-log');
    }
}
