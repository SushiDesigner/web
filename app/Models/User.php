<?php

namespace App\Models;

use App\Discord\User as DiscordUser;
use App\Roles\Roles;
use App\Models\InviteKey;
use App\Models\Ban;
use App\Models\Status;
use App\Models\Friendship;
use App\Models\ForumThread;
use App\Models\ForumReply;
use App\Notifications\AccountSecurityNotification;
use App\Roles\Economy;
use App\Roles\Forums;
use App\Roles\Places;
use App\Roles\Users;
use App\Roles\SelfHostedServers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use BjornVoesten\CipherSweet\Concerns\WithAttributeEncryption;
use BjornVoesten\CipherSweet\Casts\Encrypted as CipherSweetEncrypted;
use Database\Factories\UserFactory;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use Notifiable, Searchable, WithAttributeEncryption, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'past_usernames',
        'blurb',
        'email',
        'password',
        'last_ip_address',
        'register_ip_address',
        'activity',
        'current_ban_id',
        'permissions',
        'superadmin',
        'discord_id',
        'current_status_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'email',
        'email_index',
        'password',
        'register_ip_address',
        'register_ip_address_index',
        'last_ip_address',
        'last_ip_address_index',
        'remember_token',
        'discord_id',
        'discord_id_index',
        'discord_linked_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'past_usernames' => 'array',
        'email' => CipherSweetEncrypted::class,
        'email_verified_at' => 'datetime',
        'register_ip_address' => CipherSweetEncrypted::class,
        'last_ip_address' => CipherSweetEncrypted::class,
        'activity' => 'array',
        'permissions' => 'array',
        'discord_id' => CipherSweetEncrypted::class,
        'discord_linked_at' => 'datetime',
    ];

    /**
     * Sends an account security notification to the email address associated with this account.
     *
     * @param string $what
     * @param string $ip_address
     * @param string $userAgent
     */
    private function securityNotification(string $what, string $ip_address, string $userAgent)
    {
        $this->notify(new AccountSecurityNotification(
            $what,
            $ip_address,
            $userAgent,
            $this
        ));
    }

    /**
     * Whether or not the user is online on a given place.
     *
     * @param string $place
     * @return bool
     */
    public function isOnline(string $place): bool
    {
        return is_online($this->activity[$place]);
    }

    /**
     * The timestamp of when the user was last seen on a given place.
     *
     * @param string $place
     * @return int
     */
    public function lastSeen(string $place): int
    {
        return $this->activity[$place];
    }

    /**
     * The amount of seconds relative to when the user was last seen on a given place.
     *
     * @param string $place
     * @return int
     */
    public function lastSeenRelative(string $place): int
    {
        return time() - $this->activity[$place];
    }

    /**
     * If the user has enough money to perform a given purchase.
     *
     * @param int $amount
     * @return bool
     */
    public function hasEnoughMoney(int $amount): bool
    {
        return true;
    }

    /**
     * Spends a certain amount of the users account balance on a given item or thing.
     *
     * @param int $amount
     * @param mixed $on
     */
    public function spend(int $amount, mixed $on)
    {

    }

    /**
     * Gets the current Discord account for this user.
     *
     * @return ?DiscordUser
     */
    public function discordAccount(): ?DiscordUser
    {
        if (is_null($this->discord_id))
        {
            return null;
        }

        return new DiscordUser($this->discord_id);
    }

    /**
     * Gets this users current status.
     */
    public function status()
    {
        return $this->hasOne(Status::class, 'creator_id', 'current_status_id');
    }

    /**
     * Sets this users current status.
     *
     * @param Status $status
     */
    public function updateStatus(Status $status)
    {
        $this->update(['current_status_id' => $status->id]);
    }

    /**
     * Gets the users friends.
     *
     * @return Collection
     */
    public function friends(): Collection
    {
        return Friendship::where(function ($query) {
            $query->where('requester_id', $this->id)->orWhere('receiver_id', $this->id);
        })->where('accepted', true)->get();
    }

    /**
     * Gets the users incoming friend requests.
     *
     * @return Collection
     */
    public function friendRequests(): Collection
    {
        return Friendship::where(function ($query) {
            $query->Where('receiver_id', $this->id);
        })->where('accepted', false)->get();
    }

    /**
     * The user's threads.
     */
    public function threads()
    {
        return $this->hasMany(ForumThread::class, 'author_id');
    }

    /**
     * The user's replies.
     */
    public function replies()
    {
        return $this->hasMany(ForumReply::class, 'author_id');
    }

    /**
     * Updates this user's username.
     *
     * @param string $new_username
     * @param string $ip_address
     * @param string $user_agent
     */
    public function updateUsername(string $new_username, string $ip_address, string $user_agent)
    {
        $this->spend(config('tadah.username_change_cost'), sprintf('Username change from %s to %s', $this->username, $new_username));

        $this->securityNotification(
            sprintf('Your username has been changed to **%s** for **%s %s**.', $new_username, config('tadah.username_change_cost'), config('tadah.currency_name')),
            $ip_address,
            $user_agent
        );

        $history = $this->past_usernames ?? (object) [];
        $history[$this->username] = time();
        $this->update(['past_usernames' => $history]);

        $this->update(['username' => $new_username]);
    }

    /**
     * Updates this user's email address.
     *
     * @param string $new_email
     * @param string $ip_address
     * @param string $user_agent
     */
    public function updateEmail(string $new_email, string $ip_address, string $user_agent)
    {
        $this->securityNotification('Your email has been changed to **' . $new_email. '**.', $ip_address, $user_agent);
        $this->update(['email' => $new_email, 'email_verified_at' => null]);
    }

    /**
     * Updates this user's password.
     *
     * @param string      $new_password
     * @param string      $ip_address
     * @param string      $user_agent
     * @param ?string $current_password
     */
    public function updatePassword(string $new_password, string $ip_address, string $user_agent, ?string $current_password = null)
    {
        $this->securityNotification('Your password has been reset.', $ip_address, $user_agent);

        if (is_null($current_password))
        {
            Auth::logoutOtherDevices($current_password);
        }

        $this->forceFill([
            'password' => Hash::make($new_password)
        ])->setRememberToken(Str::random(60));

        $this->save();
    }

    /**
     * Whether or not this username has ever changed their username in the past.
     *
     * @return bool
     */
    public function hasChangedUsername(): bool
    {
        return !empty($this->past_usernames);
    }

    /**
     * Gets the most recent usernames of this user's username change history.
     *
     * @param int $amount = 3
     * @return array
     */
    public function mostRecentUsernames(int $amount = 3): array
    {
        if (!$this->hasChangedUsername())
        {
            return [ $this->username ];
        }

        // flip it so that it changes from "username" => "timestamp"
        $flipped = array_flip($this->past_usernames);
        $timestamps = array_keys($flipped);

        // sort the timestamps, so we get the newest usernames first
        sort($timestamps);
        $chunk = array_slice($timestamps, 0, $amount);

        // now, using the flipped array, access the top timestamps to get our username
        $usernames = [];
        for ($i = 0; $i < $amount; $i++)
        {
            if (!isset($chunk[$i]))
            {
                break;
            }

            $usernames[] = $flipped[$chunk[$i]];
        }

        return $usernames;
    }

    /**
     * Gets the most recent username from the username change history.
     *
     * @return string
     */
    public function mostRecentUsername(): string
    {
        return $this->mostRecentUsernames(1)[0];
    }

    /**
     * Whether or not this user is permitted to do a certain action.
     *
     * @param string $roleset
     * @param int $flag
     * @param bool $forget_superadmin = false
     * @return bool
     */
    public function may(string $roleset, int $flag, bool $forget_superadmin = false): bool
    {
        return ($this->permissions[$roleset] & $flag) != 0 || (!$forget_superadmin && $this->isSuperAdmin());
    }

    /**
     * Allows this user to do something on a specific roleset.
     *
     * @param string $roleset
     * @param int $flag
     */
    public function allow(string $roleset, int $flag)
    {
        $permissions = $this->permissions;
        $permissions[$roleset] &= $flag;

        $this->update(['permissions', $permissions]);
    }

    /**
     * Removes a permission from this user's roleset.
     *
     * @param string $roleset
     * @param int $flag
     */
    public function deny(string $roleset, int $flag)
    {
        $this->allow($roleset, ~$flag);
    }

    /**
     * Whether or not this user is a superadmin.
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->superadmin === true;
    }

    /**
     * Whether or not this user is banned.
     *
     * @return bool
     */
    public function isBanned(): bool
    {
        if (!is_null($this->current_ban_id))
        {
            if ($this->ban->is_active)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * The current ban associated with this user (if any.)
     */
    public function ban()
    {
        return $this->belongsTo(Ban::class, 'current_ban_id');
    }

    /**
     * Punishes another user.
     *
     * @param User $user
     * @param array $data
     */
    public function punish(User $user, array $data)
    {
        $ban = Ban::create(array_merge([
            'moderator_id' => $this->id,
            'user_id' => $user->id,
        ], $data));

        $user->update(['current_ban_id' => $ban->id]);

        return $ban;
    }

    /**
     * Pardons another user.
     *
     * @param User $user
     * @param string $internal_reason
     */
    public function pardon(User $user, string $internal_reason)
    {
        $user->ban->update([
            'has_been_pardoned' => true,
            'pardoner_id' => $this->id,
            'pardon_internal_reason' => $internal_reason,
        ]);

        $user->ban->lift();
    }

    /**
     * Pardons an IP address ban.
     *
     * @param IpAddressBan $ip_address_ban
     */
    public function pardonIpAddressBan(IpAddressBan $ip_address_ban)
    {
        $ip_address_ban->update([
            'has_been_pardoned' => true,
            'pardoner_id' => $this->id,
        ]);

        $ip_address_ban->lift();
    }

    /**
     * All associated accounts with this user.
     *
     * @return mixed
     */
    public function getAssociatedAccounts(): mixed
    {
        return self::whereEncrypted('register_ip_address', '=', $this->register_ip_address)
            ->orWhereEncrypted('last_ip_address', '=', $this->last_ip_address);
    }

    /**
     * Whether or not this user has linked a Discord account yet.
     *
     * @return bool
     */
    public function hasLinkedDiscordAccount(): bool
    {
        return !is_null($this->discord_id) && !is_null($this->discord_linked_at);
    }

    /**
     * Whether or not this user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Links a Discord account to this user.
     *
     * @param int $discord_id
     */
    public function linkDiscordAccount(int $discord_id)
    {
        $this->update([
            'discord_id' => $discord_id,
            'discord_linked_at' => now()
        ]);
    }

    /**
     * Unlinks the currently linked Discord account.
     */
    public function unlinkDiscordAccount()
    {
        $this->update([
            'discord_id' => null,
            'discord_linked_at' => null
        ]);
    }

    /**
     * Forcefully sets the permissions object of this user.
     *
     * @param object|array $permissions
     */
    public function forceSetPermissions(object|array $permissions)
    {
        $this->update(compact('permissions'));
    }

    /**
     * Sets the last IP address of this user.
     *
     * @param string $ip_address
     */
    public function setLastIpAddress(string $ip_address)
    {
        $this->update([
            'last_ip_address' => $ip_address
        ]);
    }

    /**
     * The default activity to be used on any given user.
     *
     * @return array
     */
    public static function defaultActivity(): array
    {
        $activity = [];

        foreach (['website', 'studio'] as $place)
        {
            $activity[$place] = time();
        }

        return $activity;
    }

    /**
     * The default permissions to be used on any given user.
     *
     * @return array
     */
    public static function defaultPermissions(): array
    {
        $permissions = [];
        $rolesets = Roles::allRolesets();

        foreach ($rolesets as $roleset)
        {
            $flags = 0;

            switch ($roleset)
            {
                case Places::roleset():
                    $flags |= Places::CREATION;
                    break;
                case SelfHostedServers::roleset():
                    $flags |= SelfHostedServers::CREATION;
                    break;
                case Economy::roleset():
                    $flags |= Economy::CREATE_ASSETS
                        | Economy::SELL_ASSETS
                        | Economy::COMMENTS;
                    break;
                case Users::roleset():
                    $flags |= Users::UPDATE_BLURB
                        | Users::SEND_FRIEND_REQUESTS
                        | Users::SEND_MESSAGES
                        | Users::VIEW_BAN_HISTORY;
                    break;
                case Forums::roleset():
                    $flags |= Forums::CREATE_THREADS
                        | Forums::CREATE_REPLIES;
                    break;
            }

            $permissions[$roleset] = $flags;
        }

        return $permissions;
    }

    /**
     * Creates a new user.
     *
     * @param object|array $input
     * @param string $ip_address
     *
     * @return User
     */
    public static function register($input, $ip_address)
    {
        if (!is_object($input))
        {
            $input = (object) $input;
        }

        if (config('tadah.invite_keys_required'))
        {
            if (is_null($input->key))
            {
                throw new \Exception('Invite key required');
            }

            $invite_key = InviteKey::whereEncrypted('token', '=', $input->key)->first();
            $invite_key->use();
        }

        $user = self::create([
            'username' => $input->username,
            'email' => $input->email,
            'password' => Hash::make($input->password),
            'last_ip_address' => $ip_address,
            'register_ip_address' => $ip_address,
            'activity' => self::defaultActivity(),
            'permissions' => self::defaultPermissions(),
        ]);

        Auth::login($user);
        event(new Registered($user));

        return $user;
    }

    /**
    * Create a factory of users for testing
    *
    * @return \Illuminate\Database\Eloquent\Factories\Factory
    */
    protected static function factory()
    {
        return UserFactory::new();
    }

    /**
    * Searchable fields
    *
    * @return array
    */
    public function toSearchableArray()
    {
        return [
            'username' => $this->username,
        ];
    }
}
