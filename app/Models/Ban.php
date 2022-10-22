<?php

namespace App\Models;

use App\Models\User;
use App\Models\PoisonedIpAddress;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Ban extends Model
{
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'moderator_id',
        'user_id',
        'internal_reason',
        'moderator_note',
        'offensive_item',
        'expiry_date',
        'is_appealable',
        'is_poison_ban',
        'patient_zero',
        'is_warning',
        'has_been_pardoned',
        'pardon_internal_reason',
        'pardoner_id',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expiry_date' => 'datetime'
    ];

    /**
     * Poisons the ban by banning the IP addresses and users of this account and all accounts associated with it.
     */
    public function poison()
    {
        if (count($this->poisonedIpAddresses) != 0)
        {
            return;
        }

        $this->update([
            'is_poison_ban' => true,
            'patient_zero' => $this->user_id,
        ]);

        PoisonedIpAddress::create([
            'ip_address' => $this->user->register_ip_address,
            'tied_to' => $this->id,
        ]);

        PoisonedIpAddress::create([
            'ip_address' => $this->user->last_ip_address,
            'tied_to' => $this->id,
        ]);

        foreach ($this->user->getAssociatedAccounts() as $user)
        {
            $user->update(['current_ban_id' => $this->id]);

            PoisonedIpAddress::create([
                'ip_address' => '127.0.0.1',
                'tied_to' => $this->id,
            ]);

            PoisonedIpAddress::create([
                'ip_address' => $user->register_ip,
                'tied_to' => $this->id,
            ]);
        }
    }

    /**
     * Unpoisons the ban.
     */
    public function cure()
    {
        if (!$this->is_poison_ban)
        {
            return;
        }

        foreach ($this->poisonedIpAddresses as $ip_address)
        {
            $ip_address->delete();
        }

        foreach ($this->user->getAssociatedAccounts() as $user)
        {
            $user->update(['current_ban_id' => null]);
        }
    }

    /**
     * The IP addresses associated with this ban that are not allowed to create an account.
     */
    public function poisonedIpAddresses()
    {
        return $this->hasMany(PoisonedIpAddress::class, 'tied_to', 'id');
    }

    /**
     * Lifts the ban. If this is a poison ban, the ban gets cured.
     */
    public function lift()
    {
        $this->update([
            'is_active' => false
        ]);

        $this->user->update([
            'current_ban_id' => null
        ]);

        if ($this->is_poison_ban)
        {
            $this->cure();
        }
    }

    /**
     * The user that has been banned.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * The moderator that performed this ban.
     */
    public function moderator()
    {
        return $this->hasOne(User::class, 'id', 'moderator_id');
    }

    /**
     * The moderator that pardoned this ban (if any.)
     */
    public function pardoner()
    {
        return $this->hasOne(User::class, 'id', 'pardoner_id');
    }

    /**
     * The user that was originally poisoned banned associated with this ban.
     */
    public function patientZero()
    {
        return $this->hasOne(User::class, 'id', 'patient_zero');
    }

    public function toSearchableArray()
    {
        return [ 'username' => $this->user->username ];
    }
}
