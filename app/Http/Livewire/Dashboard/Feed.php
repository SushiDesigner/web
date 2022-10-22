<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class Feed extends Component
{
    /**
     * @var string
     */
    public $status;

    /**
     * @var bool
     */
    public $loading = true;

    /**
     * @var array
     */
    protected $rules = [
        'status' => ['required', 'min:3', 'max:140'],
    ];

    public function __construct()
    {
        abort_unless(Auth::check(), 401);
    }

    public function load()
    {
        $this->loading = false;
    }

    public function share()
    {
        $this->validate();

        /** @var \App\Models\User */
        $user = Auth::user();
        $key = ('create-feed-post:' . $user->id);

        if (RateLimiter::tooManyAttempts($key, 1))
        {
            $wait = RateLimiter::availableIn($key);
            return $this->addError('status', __('Please wait :time before updating your status.', ['time' => seconds2human($wait, true)]));;
        }

        RateLimiter::hit('create-feed-post:' . Auth::user()->id, 300);

        $status = Status::create([
            'content' => $this->status,
            'creator_id' => $user->id
        ]);

        $user->updateStatus($status);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function render()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        $posts = collect([]);

        $this->status = $user->status?->content ?? '';

        if ($this->loading)
        {
            return view('livewire.dashboard.feed', compact('posts', 'user'));
        }

        // ... merge users own posts
        $posts = $posts->merge(Status::where('creator_id', $user->id)->get());

        // ... merge posts from friends
        $friends = $user->friends()->pluck('id')->all();
        $posts = $posts->merge(Status::whereIn('creator_id', $friends)->get());

        // ... merge posts from groups
        // TODO

        // ... sort
        $posts = $posts->sortByDesc('id');

        return view('livewire.dashboard.feed', compact('posts', 'user'));
    }
}
