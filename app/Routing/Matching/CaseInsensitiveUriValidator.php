<?php

// https://stackoverflow.com/questions/31964973/how-to-make-routes-in-laravel-case-insensitive

namespace App\Routing\Matching;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Matching\ValidatorInterface;

class CaseInsensitiveUriValidator implements ValidatorInterface
{
    public function matches(Route $route, Request $request)
    {
        $path = $request->path() == '/' ? '/' : '/'.$request->path();
        return preg_match(preg_replace('/$/','i', $route->getCompiled()->getRegex()), rawurldecode($path));
    }
}
