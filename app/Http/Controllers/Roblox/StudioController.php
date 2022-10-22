<?php

namespace App\Http\Controllers\Roblox;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Roblox\Script\ScriptBuilder;

class StudioController extends Controller
{
    public function edit(Request $request)
    {
        $placeId = $request->input('PlaceID');
        $parameters = ScriptBuilder::defaultParameters();

        if (is_numeric($placeId))
        {
            $parameters['PlaceID'] = $placeId;
            $parameters['AssetUrl'] = $parameters['BaseUrl'] . "/asset/?id=" . $placeId;
            $parameters['ClientPresenceUrl'] = $parameters['BaseUrl'] . "/Game/ClientPresence.ashx?PlaceID=" . $placeId . "&LocationType=Studio";
        }

        return response()->text(ScriptBuilder::from(['SingleplayerSharedScript', 'Edit'])->render($parameters)->sign());
    }

    public function studio(Request $request)
    {
        $parameters = [
            'BaseUrl' => "http://" . $request->getHost(),
            'StarterScriptID' => 37801172
        ];

        return response()->text(ScriptBuilder::from('Studio')->render($parameters)->sign());
    }
}
