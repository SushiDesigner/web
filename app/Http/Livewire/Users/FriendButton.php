<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use App\Models\Friendship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class FriendButton extends Component
{
    /**
     * @var \App\Models\User
     */
    public $user;

    public function __construct()
    {
        abort_unless(Auth::check(), 401);
    }

    public function request()
    {
        $friendship = Friendship::getMutual(Auth::user()->id, $this->user->id);

        if (!is_null($friendship))
        {
            if ($friendship->accepted)
            {
                $this->dispatchBrowserEvent('error', __('You are already friends with this user.'));
            }
            else if ($friendship->receiver_id == Auth::user()->id)
            {
                $this->dispatchBrowserEvent('error', __('You already have an incoming friend request from this user.'));
            }
            else
            {
                $this->dispatchBrowserEvent('error', __('You have already sent a friend request to this user.'));
            }


            return;
        }

        if (RateLimiter::tooManyAttempts('submit-friend-request:' . Auth::user()->id, 1))
        {
            $wait = RateLimiter::availableIn('submit-friend-request:' . Auth::user()->id);
            $this->dispatchBrowserEvent('error', __('Please wait :time before sending another friend request.', ['time' => seconds2human($wait)]));
            return;
        }

        RateLimiter::hit('submit-friend-request:' . Auth::user()->id, 60);

        Friendship::create([
            'requester_id' => Auth::user()->id,
            'receiver_id' => $this->user->id
        ]);
    }

    public function accept()
    {
        $friendship = Friendship::getMutual(Auth::user()->id, $this->user->id);

        if (is_null($friendship) || $friendship->receiver_id != Auth::user()->id)
        {
            $this->dispatchBrowserEvent('error', __('You don\'t currently have a pending friend request from this user.'));
            return;
        }

        if ($friendship->accepted)
        {
            $this->dispatchBrowserEvent('error', __('You are already friends with this user!'));
            return;
        }

        $friendship->update(['accepted' => true]);
    }

    public function revoke()
    {
        $friendship = Friendship::getMutual(Auth::user()->id, $this->user->id);

        if (is_null($friendship))
        {
            $this->dispatchBrowserEvent('error', __('You don\'t have an existing friend connection with this user.'));
            return;
        }

        $friendship->delete();
    }

    public function render()
    {
        $user = $this->user;
        $friendship = Friendship::getMutual(Auth::user()->id, $this->user->id);
        return view('livewire.users.friend-button', compact('user', 'friendship'));
    }
}
