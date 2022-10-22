<?php

namespace App\Http\Controllers\Roblox;

use App\Http\Controllers\Controller;

class StaticAssetController extends Controller
{
    public function getScriptState()
    {
        return response()->text('0 0 0 0');
    }

    public function chatFilter()
    {
        return response()->text('True');
    }

    public function keepAlivePinger()
    {
        // TODO: make this functional?
        // supposedly this is to preserve the user's online presence when the client is open
        // i'm not entirely sure what the response is supposed to be? archived pages just show 8 (for logged out users)
        // but when you're logged it shows a unique number on each request (presumably random? - https://archive.froast.io/forum/32957261)

        return response()->text('8');
    }

    public function respondWithOK()
    {
        return response()->text('OK');
    }
}
