<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ban;
use App\Roles\Users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BanInformationController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next)
        {
            if (!$request->user()->may(Users::roleset(), Users::MODERATION_VIEW_BAN_LIST))
            {
                return abort(404);
            }

            return $next($request);
        });
    }

    public function __invoke(Request $request)
    {
        $ban = Ban::findOrFail($request->input('id'));

        return response()->json([
            'success' => true,
            'ban' => [
                'pardon_internal_reason' => $ban->pardon_internal_reason,
                'offensive_item' => $ban->offensive_item,
                'internal_reason' => $ban->internal_reason,
                'moderator_note' => $ban->moderator_note,
                'is_appealable' => $ban->is_appealable,
                'has_been_pardoned' => $ban->has_been_pardoned
            ]
        ]);
    }
}
