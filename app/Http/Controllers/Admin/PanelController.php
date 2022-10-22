<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Roles\Admin;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next)
        {
            if (!$request->user()->may(Admin::roleset(), Admin::VIEW_PANEL))
            {
                return abort(404);
            }

            return $next($request);
        });
    }

    public function __invoke(Request $request)
    {
        return view('admin.panel')->with('user', $request->user());
    }
}
