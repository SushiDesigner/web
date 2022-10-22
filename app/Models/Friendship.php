<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Friendship extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'requester_id',
        'receiver_id',
        'accepted'
    ];

    /**
     * Gets a mutual relationship between two users.
     *
     * @param int $firstUserId
     * @param int $secondUserId
     * @return Friendship
     */
    public static function getMutual(int $firstUserId, int $secondUserId)
    {
        return self::whereIn('requester_id', [$firstUserId, $secondUserId])->whereIn('receiver_id', [$firstUserId, $secondUserId])->first();
    }

    /**
     * The user that made the friend request.
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    /**
     * The user that received the friend request.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
