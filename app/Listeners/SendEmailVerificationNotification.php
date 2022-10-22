<?php

namespace App\Listeners;

use Illuminate\Contracts\Auth\MustVerifyEmail;

class SendEmailVerificationNotification
{
    /**
     * Sends an email verification notification to the user.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (!config('app.email_verification'))
        {
            return;
        }

        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail())
        {
            $event->user->sendEmailVerificationNotification();
        }
    }
}
