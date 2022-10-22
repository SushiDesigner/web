<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Rules\IsValidSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function __invoke(Request $request)
    {
        try
        {
            $data = $request->validate([
                'key' => ['required', new IsValidSession($request->user())]
            ]);
        }
        catch (ValidationException)
        {
            return response()->json(['success' => false]);
        }

        $key = decrypt($data['key']);
        if ($key == $request->session()->getId())
        {
            Auth::logout();
        }
        else
        {
            Session::getHandler()->destroy($key);
        }

        return response()->json(['success' => true]);
    }
}
