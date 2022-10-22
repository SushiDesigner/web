<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @var array
     */
    private $greetings = ['Hi', 'Howdy', 'Ahoy', 'Bonjour', 'Hola', 'Olá', '您好', 'Привет', 'سلام', 'Hallo', 'Hej', 'Ciao', 'Hello'];

    public function __invoke(Request $request)
    {
        $status = null;
        if ($request->has('verified') && !is_null($request->user()->email_verified_at))
        {
            if ((time() - $request->user()->email_verified_at->timestamp) <= 30)
            {
                $status = __('Welcome to :project!', ['project' => config('app.name')]);
            }
        }

        $greeting = $this->greetings[mt_rand(0, count($this->greetings) - 1)];
        $username = $request->user()->username;

        return view('my.dashboard', compact('status', 'greeting', 'username'));
    }
}
