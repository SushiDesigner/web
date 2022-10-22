<?php

namespace App\Http\Controllers\Roblox;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Roblox\Script\ScriptBuilder;

class OnlinePlayController extends Controller
{
    public function multiplayer(Request $request)
    {
        $placeId = $request->input('placeId');
        $machineAddress = $request->input('server');
        $machinePort = $request->input('serverPort');

        $parameters = [
            ... ScriptBuilder::defaultParameters(),
            'PlaceID' => -1
        ];

        // TODO: generate screenshot and video info when placeid parameter is not -1 (@pizzaboxer)
        if ($request->has('jobID'))
        {
            // TODO: we probably won't use job ids for joinscript generation anyway (@pizzaboxer)
            // Carrot: why?

            $jobId = $request->input('jobID');
        }
        else
        {
            if (is_numeric($placeId))
            {
                $parameters['PlaceID'] = $placeId;
            }

            // make sure the machine address given is a local ip
            // this probably isn't necessary? eh
            if (is_ipv4($machineAddress))
            {
                $parameters['MachineAddress'] = $machineAddress;
            }

            if (is_port($machinePort))
            {
                $parameters['MachinePort'] = $machinePort;
            }
        }

        /* "ScreenShotInfo":"Crossroads%0d%0aA+fun+game+by+Player%0d%0aBuilt+in+ROBLOX%2c+the+free+online+building+game.+%0d%0ahttp%3a%2f%2fwww.roblox.com%2fCrossroads-place%3fid%3d1818%0d%0aMore+about+this+level%3a%0d%0aThe+classic+ROBLOX+level+is+back!" */
        /* "VideoInfo":"<?xml version=\"1.0\"?><entry xmlns=\"http://www.w3.org/2005/Atom\" xmlns:media=\"http://search.yahoo.com/mrss/\" xmlns:yt=\"http://gdata.youtube.com/schemas/2007\"><media:group><media:title type=\"plain\"><![CDATA[Crossroads by ROBLOX]]></media:title><media:description type=\"plain\"><![CDATA[The classic ROBLOX level is back!\\n\\n Visit this place at http://www.roblox.com/Crossroads-place?id=1818\\n\\nFor more games visit http://www.roblox.com]]></media:description><media:category scheme=\"http://gdata.youtube.com/schemas/2007/categories.cat\">Games</media:category><media:keywords>ROBLOX, video, free game, online virtual world</media:keywords></media:group></entry> */

        $scripts = [];

        switch ($request->route()->getName())
        {
            case 'client.online.join':
                $scripts[] = 'Join';
                break;
            case 'client.online.group-build':
                $scripts[] = 'GroupBuild';
                break;
        }

        $scripts[] = 'MultiplayerSharedScript';

        return response()->text(ScriptBuilder::from($scripts)->render($parameters)->sign());
    }

    public function singleplayer(Request $request)
    {
        $placeId = $request->input('placeId');
        $uploadingTo = $request->input('upload');

        $parameters = ScriptBuilder::defaultParameters();

        if (is_numeric($placeId))
        {
            $parameters['IsVisit'] = true;
            $parameters['PlaceID'] = $placeId;
            $parameters['AssetUrl'] = $parameters['BaseUrl'] . "/asset/?id=" . $placeId;
        }

        if (Auth::check())
        {
            $user = $request->user();

            $parameters['PlayerName'] = $request->user()->username;
            $parameters['PlayerID'] = $request->user()->id;
            $parameters['PlayerAppearance'] = $parameters['BaseUrl'] . '/Asset/CharacterFetch.ashx?userId=' . $parameters['PlayerID'] . '&placeId=' . $parameters['PlaceID'];
            $parameters['PlayerSSC'] = 'false';
            $parameters['ClientPresenceUrl'] = $parameters['BaseUrl'] . "/Game/ClientPresence.ashx?PlaceID=" . $parameters['PlaceID'];

            if (is_numeric($uploadingTo))
            {
                $parameters['UploadUrl'] = $parameters['BaseUrl'] . "/Data/Upload.ashx?assetid=" . $uploadingTo;
            }
        }
        else
        {
            $parameters['PlayerName'] = 'Guest ' . rand(0, 9999);
            $parameters['PlayerAppearance'] = $parameters['BaseUrl'] . '/Asset/CharacterFetch.ashx?userId=1&placeId=' . $parameters['PlaceID'];
        }

        $scripts = ['SingleplayerSharedScript'];

        switch ($request->route()->getName())
        {
            case 'client.online.visit':
                $scripts[] = 'Visit';
                break;
            case 'client.online.solo':
                $scripts[] = 'PlaySolo';
                break;
        }

        return response()->text(ScriptBuilder::from($scripts)->render($parameters)->sign());
    }
}
