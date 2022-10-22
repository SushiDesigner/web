<?php

namespace App\Roblox\Script;

use App\Enums\ChatStyle;
use Illuminate\Support\Facades\Storage;

class ScriptBuilder
{
    /**
     * The default parameters used in scripts.
     *
     * @return array
     */
    public static function defaultParameters(): array
    {
        return [
            'AssetUrl' => '',
            'BaseUrl' => config('app.url'),
            'ChatStyle' => ChatStyle::Classic,
            'ClientPresenceUrl' => '',
            'CreatorID' => 0,
            'CreatorType' => 'User',
            'IsTeleport' => 'false',
            'IsTest' => 'true',
            'IsVisit' => 'false',
            'JobID' => '',
            'MachineAddress' => 'localhost',
            'MachinePort' => 53640,
            'OfficialPlace' => false,
            'PlaceID' => 0,
            'PlayerAge' => 0,
            'PlayerAppearance' => '',
            'PlayerID' => 0,
            'PlayerMembership' => 'None',
            'PlayerName' => 'Player',
            'PlayerSSC' => true,
            'PlayerTicket' => '',
            'ScreenshotInfo' => '',
            'VideoInfo' => '',
            'UploadUrl' => ''
        ];
    }

    /**
     * Creates a script.
     *
     * @param array|string $scripts
     * @return Script
     */
    public static function from(array|string $scripts): Script
    {
        $built = '';
        $scripts = collect($scripts);

        $scripts->each(function ($script) use (&$built) {
            $built .= Storage::disk('resources')->get('lua/' . $script . '.lua');
        });

        return new Script($built);
    }
}
