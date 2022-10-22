<?php

namespace App\Providers;

use App\Events;
use App\Listeners;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            Listeners\SendEmailVerificationNotification::class,
        ],

        Events\GameServer\ConsoleOutput::class => [
            Listeners\GameServer\AppendConsoleOutput::class,
        ],

        Events\GameServer\ResourceReport::class => [
            Listeners\GameServer\Ping::class
        ],

        Events\GameServer\StateChange::class => [
            Listeners\GameServer\ChangeState::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
