<?php

namespace App\Http\Livewire\Admin\Ban;

use App\Roles\Users;
use App\Models\User as UserModel;
use App\Models\Action;
use App\Enums\Actions;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Livewire\Component;

class User extends Component
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $moderator_note;

    /**
     * @var string
     */
    public $internal_reason;

    /**
     * @var int
     */
    public $duration_preset = 0;

    /**
     * @var ?string
     */
    public $offensive_item = null;

    /**
     * @var ?string
     */
    public $custom_expiry_date = null;

    /**
     * @var mixed
     */
    public $is_appealable = true;

    public function __construct()
    {
        abort_unless(Auth::check(), 401);

        /** @var \App\Models\User */
        $user = Auth::user();
        abort_unless($user->may(Users::roleset(), Users::MODERATION_GENERAL_BAN), 401);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => ['required', Rule::exists(UserModel::class)],
            'moderator_note' => ['required', 'max:255'],
            'internal_reason' => ['required', 'max:255'],
            'duration_preset' => ['required', Rule::in([0, 1, 2, 3, 4, 5, 6, 7])],
            'offensive_item' => ['nullable'],
            'custom_expiry_date' => ['required_if:duration_preset,6', 'date', 'after:today', 'nullable'],
        ];
    }

    public function render()
    {
        return view('livewire.admin.ban.user');
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function submit()
    {
        $data = $this->validate();
        $user = UserModel::where('username', $data['username'])->first();

        if ($user->isBanned())
        {
            return $this->addError('username', __('That user is already banned.'));
        }

        if ($user->username == Request::user()->username)
        {
            return $this->addError('username', __('You may not moderate yourself.'));
        }

        if ($user->isSuperAdmin())
        {
            return $this->addError('username', __('You may not moderate superadmins.'));
        }

        $is_warning = $data['duration_preset'] == 0;
        $is_poison_ban = $data['duration_preset'] == 7;
        $expiry_date = null;

        if (!$is_warning && !$is_poison_ban)
        {
            $expiry_date = match($data['duration_preset'])
            {
                '1' => Carbon::now()->addDays(1),               // 1 day
                '2' => Carbon::now()->addDays(3),               // 3 days
                '3' => Carbon::now()->addDays(7),               // 7 days
                '4' => Carbon::now()->addDays(14),              // 14 days
                '5' => null,                                    // Account Deletion
                '6' => Carbon::parse($data['custom_expiry_date']) // Custom Date
            };
        }

        if ($is_warning)
        {
            Request::user()->punish($user, [
                'internal_reason' => $data['internal_reason'],
                'moderator_note' => $data['moderator_note'],
                'offensive_item' => $data['offensive_item'],
                'is_warning' => true,
            ]);

            Action::log(Request::user(), Actions::WarnedUser, $user);
        }
        else
        {
            $ban = Request::user()->punish($user, [
                'internal_reason' => $data['internal_reason'],
                'moderator_note' => $data['moderator_note'],
                'offensive_item' => $data['offensive_item'],
                'expiry_date' => $expiry_date,
                'is_appealable' => !empty($this->is_appealable),
            ]);

            if (Request::user()->may(Users::roleset(), Users::MODERATION_POISON_BAN) && $is_poison_ban)
            {
                $user->ban->poison();

                Action::log(Request::user(), Actions::PoisonBannedUser, $user);
            }
            else
            {
                if ($expiry_date)
                {
                    Action::log(Request::user(), Actions::TempBannedUser, $ban);
                }
                else
                {
                    Action::log(Request::user(), Actions::PermBannedUser, $user);
                }
            }
        }

        return $this->dispatchBrowserEvent('success', __('Successfully punished user <b>:username</b>!', ['username' => $user->username]));
    }
}
