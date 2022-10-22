<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function list()
    {
        return view('users.list');
    }

    public function profile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $num_friends = $user->friends()->count();
        return view('users.profile', compact('user', 'num_friends'));
    }
}
