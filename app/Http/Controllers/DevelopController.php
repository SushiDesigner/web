<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DevelopController extends Controller
{
    public function index(Request $request)
    {
        return view('develop.index');
    }
}
