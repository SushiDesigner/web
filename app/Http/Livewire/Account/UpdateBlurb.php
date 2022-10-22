<?php

namespace App\Http\Livewire\Account;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class UpdateBlurb extends Component
{
    /**
     * @var string
     */
    public $blurb;

    /**
     * @var array
     */
    protected $rules = [
        'blurb' => ['max:1000'],
    ];

    public function __construct()
    {
        abort_unless(Auth::check(), 401);
    }

    public function mount()
    {
        $this->blurb = Auth::user()->blurb;
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function submit()
    {
        $this->validate();

        /** @var \App\Models\User */
        $user = Auth::user();

        if (RateLimiter::tooManyAttempts('update-blurb:' . $user->id, 1))
        {
            $wait = RateLimiter::availableIn('update-blurb:' . $user->id);
            return $this->addError('blurb',  __('Please wait :time before updating your blurb.', ['time' => seconds2human($wait)]));;
        }

        RateLimiter::hit('update-blurb:' . $user->id, 300);

        $user->update(['blurb' => $this->blurb]);

        $this->dispatchBrowserEvent('success', __('Your blurb has been updated.'));
    }

    public function render()
    {
        return view('livewire.account.update-blurb');
    }
}
