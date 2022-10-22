<?php

namespace App\Http\Controllers\Roblox;

use App\Http\Controllers\Controller;
use App\Roblox\Script\ScriptBuilder;

class MiscellaneousScriptController extends Controller
{
    public function gameserver()
    {
        return response()->text(ScriptBuilder::from('Gameserver')->sign());
    }
}
