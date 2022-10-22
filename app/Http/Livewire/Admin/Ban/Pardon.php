<?php

namespace App\Http\Livewire\Admin\Ban;

use App\Models\User;
use App\Roles\Users;
use App\Models\Action;
use App\Enums\Actions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Pardon extends Component
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $pardon_reason;

    public function __construct()
    {
        abort_unless(Auth::check(), 401);

        /** @var \App\Models\User */
        $user = Auth::user();
        abort_unless($user->may(Users::roleset(), Users::MODERATION_PARDON_BAN), 401);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => ['required', Rule::exists(User::class)],
            'pardon_reason' => ['required', 'max:255']
        ];
    }

    public function render()
    {
        return view('livewire.admin.ban.pardon');
    }

    public function submit()
    {
        $data = $this->validate();
        $user = User::where('username', $data['username'])->first();

        if (!$user->isBanned())
        {
            return $this->addError('username', __('This user is not currently banned.'));
        }

        Request::user()->pardon($user, $data['pardon_reason']);
        Action::log(Request::user(), Actions::PardonedUser, $user);

        return $this->dispatchBrowserEvent('success', __('Successfully pardoned ban for user <b>:username</b>!', ['username' => $user->username]));
    }
}
