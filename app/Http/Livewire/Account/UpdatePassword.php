<?php

namespace App\Http\Livewire\Account;

use App\Traits\PasswordValidationRules;
use App\Rules\IsCurrentPassword;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class UpdatePassword extends Component
{
    use PasswordValidationRules;

    /**
     * @var string
     */
    public $current_password;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $password_confirmation;

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
     * @param User $user
     * @return array
     */
    public function rules(User $user): array
    {
        return [
            'current_password' => ['required', new IsCurrentPassword($user)],
            'password' => $this->passwordRules($user->username, $user->email),
            'password_confirmation' => $this->passwordConfirmationRules()
        ];
    }

    public function render()
    {
        return view('livewire.account.update-password');
    }

    public function submit()
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $data = $this->validate($this->rules($user));
        $user->updatePassword($data['password'], Request::ip(), Request::userAgent(), $data['current_password']);

        return redirect()->route('account')->with('status', __('Your password has been updated!'));
    }
}
