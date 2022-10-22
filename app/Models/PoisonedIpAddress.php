<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use BjornVoesten\CipherSweet\Concerns\WithAttributeEncryption;
use BjornVoesten\CipherSweet\Casts\Encrypted as CipherSweetEncrypted;

class PoisonedIpAddress extends Model
{
    use WithAttributeEncryption;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ip_address',
        'tied_to',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'ip_address',
        'ip_address_index',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ip_address' => CipherSweetEncrypted::class,
    ];
}
