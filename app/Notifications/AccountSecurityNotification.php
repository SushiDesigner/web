<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Password;

class AccountSecurityNotification extends Notification
{
    /**
     * Describes what happened to the user exactly.
     *
     * @var string
     */
    private string $what;

    /**
     * The IP address of the request.
     *
     * @var string
     */
    private string $ip_address;

    /**
     * The user agent of the request.
     *
     * @var string
     */
    private string $user_agent;

    /**
     * The user.
     *
     * @var User
     */
    private User $user;

    /**
     * Create a new notification instance.
     *
     * @param string $what
     * @param string $ip_address
     * @param string $user_agent
     * @param User $user
     */
    public function __construct(string $what, string $ip_address, string $user_agent, User $user)
    {
        $this->what = $what;
        $this->ip_address = $ip_address;
        $this->user_agent = $user_agent;
        $this->user = $user;
    }

    /**
     * The password broker used for account resets.
     */
    protected function broker()
    {
        return Password::broker(config('fortify.passwords'));
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $token = '';

        $this->broker()->sendResetLink(['email' => $this->user->getRawOriginal('email')], function ($_, $_token) use (&$token) {
            $token = $_token;
        });

        $details = '';

        if (($location = geolocate($this->ip_address)) !== false)
        {
            $details = sprintf('This action occurred from %s, %s (IP: %s) on device "%s".', $location->territory, $location->country, $this->ip_address, $this->user_agent);
        }
        else
        {
            $details = sprintf('This action occurred from IP "%s" on device "%s".', $this->ip_address, $this->user_agent);
        }

        $link = route('password.reset', ['token' => $token]) . '?email=' . urlencode($this->user->email);

        return (new MailMessage)
            ->subject('Important Security Notification for ' . $this->user->username)
            ->greeting('Hello!')
            ->line($this->what)
            ->line($details)
            ->line('If this wasn\'t you, reset your password now.')
            ->action('Reset Password', $link);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            'what' => $this->what,
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'user' => $this->user->id
        ];
    }
}
