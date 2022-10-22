<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function view(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        return view('item.view', compact('asset'));
    }

    public function configure(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        abort_unless($asset->canConfigure(), 404);

        return view('item.configure', compact('asset'));
    }
}
