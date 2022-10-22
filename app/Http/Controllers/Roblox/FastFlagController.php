<?php

namespace App\Http\Controllers\Roblox;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FastFlagController extends Controller
{
    const versions = ["2012", "2016"]; // To prevent ../../../, maybe we could list client versions in /config/tadah.php

    public function clientAppSettings(Request $request)
    {
        $version = $request->version ?? "2016";

        if (!in_array($version, self::versions)) {
            return abort(400);
        }

        $flags = Storage::disk('resources')->get((sprintf('flags/ClientAppSettings/%s.json', $version)));

        return response()->make($flags)->header('Content-Type', 'application/json');
    }
}
