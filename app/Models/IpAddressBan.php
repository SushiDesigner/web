<?php

namespace App\Models;

use App\Models\User;
use App\Events\IpAddressBanModified;
use Illuminate\Database\Eloquent\Model;
use BjornVoesten\CipherSweet\Concerns\WithAttributeEncryption;
use BjornVoesten\CipherSweet\Casts\Encrypted as CipherSweetEncrypted;

class IpAddressBan extends Model
{
    use WithAttributeEncryption;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ip_address',
        'moderator_id',
        'criterium',
        'pardoner_id',
        'has_been_pardoned',
        'internal_reason',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ip_address' => CipherSweetEncrypted::class,
        'criterium' => 'encrypted',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => IpAddressBanModified::class,
        'updated' => IpAddressBanModified::class,
        'deleting' => IpAddressBanModified::class,
        'deleted' => IpAddressBanModified::class,
    ];

    /**
     * Gets the moderator of this IP address ban.
     */
    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }

    /**
     * Gets the moderator who pardoned this IP address ban (if any.)
     */
    public function pardoner()
    {
        return $this->belongsTo(User::class, 'pardoner_id');
    }

    /**
     * Lifts the IP address ban.
     */
    public function lift()
    {
        $this->update([
            'is_active' => false
        ]);
    }
}
