<?php

namespace App\Http\Livewire\Account;

use App\Traits\UsernameValidationRules;
use App\Rules\IsCurrentPassword;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class UpdateUsername extends Component
{
    use UsernameValidationRules;

    /**
     * @var string
     */
    public $new_username;

    /**
     * @var string
     */
    public $current_password;

    public function __construct()
    {
        abort_unless(Auth::check(), 401);
    }

    public function updated($property)
    {
        if ($property == 'current_password')
        {
            return;
        }

        $this->validateOnly($property);
    }

    /**
     * @param  User $user
     * @return array
     */
    public function rules(User $user): array
    {
        return [
            'new_username' => $this->usernameRules('username'),
            'current_password' => ['required', new IsCurrentPassword($user)],
        ];
    }

    public function render()
    {
        return view('livewire.account.update-username');
    }

    public function submit()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        $data = $this->validate($this->rules($user));

        if (!$user->hasEnoughMoney(config('tadah.username_change_cost')))
        {
            return $this->dispatchBrowserEvent('alert', __('You do not have enough money to change your username.'));
        }

        $user->updateUsername($data['new_username'], Request::ip(), Request::userAgent());

        return redirect()->route('account')->with('status', __('Your username has been successfully updated!'));
    }
}
