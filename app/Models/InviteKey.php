<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use BjornVoesten\CipherSweet\Concerns\WithAttributeEncryption;
use BjornVoesten\CipherSweet\Casts\Encrypted as CipherSweetEncrypted;

class InviteKey extends Model
{
    use SoftDeletes, WithAttributeEncryption;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'creator_id',
        'token',
        'uses',
        'max_uses',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'token',
        'token_index',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'token' => CipherSweetEncrypted::class,
    ];

    /**
     * The creator of this invite key.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Uses this invite key once.
     */
    public function use()
    {
        $this->update(['uses' => $this->uses + 1]);
    }

    /**
     * Whether or not this invite key is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->uses < $this->max_uses;
    }

    /**
     * Generates a new invite key and returns the token for it.
     *
     * @param int $creator_id
     * @param int $max_uses
     * @return string
     */
    public static function generate(int $creator_id, int $max_uses): string
    {
        $token = uuid();

        self::create(compact('creator_id', 'token', 'max_uses'));

        return $token;
    }
}
