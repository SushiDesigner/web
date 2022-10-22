<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function landing()
    {
        return view('landing');
    }

    public function language($locale)
    {
        $locales = array_flip(config('app.available_locales')); // English => en_US becomes en_US => English

        if (!isset($locales[$locale]))
        {
            $locale = config('app.fallback_locale');
        }

        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }

    public function document($page)
    {
        // we can use view()->exists but it's unsafe w/ user input
        $documents = ['privacy', 'rules', 'statistics', 'tos'];
        if (!in_array($page, $documents))
        {
            return abort(404);
        }

        return view("document.{$page}");
    }
}
