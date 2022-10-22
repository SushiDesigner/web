<?php

use App\Http\Controllers;
use App\Routing\Matching\CaseInsensitiveUriValidator;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Route as Router;
use Illuminate\Routing\Matching\UriValidator;
use Illuminate\Support\Facades\Request;

// Ideally this should be handled by nginx in production and/or staging.
if (app()->environment() == 'local')
{
    $validators = Router::getValidators();
    $validators[] = new CaseInsensitiveUriValidator();

    Router::$validators = array_filter($validators, function ($validator) {
        return get_class($validator) != UriValidator::class;
    });
}

/*
 * TODO: Add these routes
 *
 * API Endpoints:
 * /Asset/Default.ashx
 * /Asset/CharacterFetch.ashx
 * /Asset/BodyColors.ashx
 *
 * /Thumbs/Avatar.ashx
 * /Thumbs/Asset.ashx
 *
 * /Game/PlaceLauncher.ashx
 * /Game/ClientPresence.ashx
 * /Game/PlaceVisit.ashx
 * /Game/PlaceSpecificScript.ashx
 * /Game/Knockouts.ashx
 * /Game/Wipeouts.ashx
 * /Game/GetAuthTicket
 * /Game/Tools/ThumbnailAsset.ashx
 * /Game/Tools/InsertAsset.ashx
 * /Game/Badge/AwardBadge.ashx
 * /Game/Badge/HasBadge.ashx
 * /Game/Badge/IsBadgeDisabled.ashx
 *
 * /ReportAbuse/InGameChatHandler.ashx
 *
 * /Friend/CreateFriend
 * /Friend/BreakFriend
 * /Friend/AreFriends
 *
 * /Login/Negotiate.ashx
 *
 * /Error/Dmp.ashx
 *
 * Webpage Endpoints:
 * /Game/Help.aspx
 *
 * /ReportAbuse/InGameChat.aspx
 *
 * /Build/Default.aspx (/develop)
 *
 * /IDE/Landing.aspx (/ide/welcome)
 * /IDE/ClientToolbox.aspx
 * /IDE/Welcome
 *
 * /UI/Save.aspx
 *
 * /UploadMedia/PostImage.aspx
 * /UploadMedia/UploadVideo.aspx
 */


Route::controller(Controllers\Roblox\StaticAssetController::class)->group(function() {
    Route::get('/Asset/GetScriptState.ashx', 'getScriptState');
    Route::get('/Game/KeepAlivePinger.ashx', 'keepAlivePinger');
    Route::get('/Game/MachineConfiguration.ashx', 'respondWithOK');
    Route::get('/Game/ChatFilter.ashx', 'chatFilter');
    Route::get('/Error/Dmp.ashx', 'respondWithOK');
});

Route::prefix('Game')->group(function() {
    Route::middleware(['web'])->controller(Controllers\Roblox\OnlinePlayController::class)->group(function() {
        Route::get('/Join.ashx', 'multiplayer')->name('client.online.join');
        Route::get('/GroupBuild.ashx', 'multiplayer')->name('client.online.group-build');

        Route::get('/Visit.ashx', 'singleplayer')->name('client.online.visit');
        Route::get('/PlaySolo.ashx', 'singleplayer')->name('client.online.solo');
    });

    Route::controller(Controllers\Roblox\StudioController::class)->group(function() {
        Route::get('/Studio.ashx', 'studio');
        Route::get('/Edit.ashx', 'edit');
    });

    Route::controller(Controllers\Roblox\MiscellaneousScriptController::class)->group(function() {
        Route::get('/Gameserver.ashx', 'gameserver');
        Route::get('/LoadPlaceInfo.ashx', 'loadPlaceInfo');
    });

    Route::get('/GetCurrentUser.ashx', function () {
        return response()->text('0');
    });

    Route::get('/LuaWebService/HandleSocialRequest.ashx', function () {
        return response()->text('');
    });

    Route::get('/LoadPlaceInfo.ashx', function () {
        return response()->text('');
    });
});

Route::prefix('Setting')->group(function() {
    Route::controller(Controllers\Roblox\FastFlagController::class)->group(function() {
        Route::get('/QuietGet/ClientAppSettings', 'clientAppSettings');
        Route::get('/QuietGet/StudioAppSettings', 'clientAppSettings');
        Route::get('/QuietGet/ClientSharedSettings', 'clientAppSettings');
        Route::get('/QuietGet/RCCService', 'clientAppSettings');
    });
});

Route::get('/studio/e.png', function () {
    return response()->text('');
});

Route::get('/GetAllowedMD5Hashes', function () {
    return response()->json([]);
});

Route::get('/GetAllowedSecurityVersions', function () {
    return response()->json([]);
});

Route::get('/universes/validate-place-join', function () {
    return response()->text('true');
});

Route::get('//game/players/{id}/', function () {
    return response()->json([
        'ChatFilter' => 'whitelist'
    ]);
});
