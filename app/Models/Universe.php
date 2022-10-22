<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Universe extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'creator_id',
        'creator_type',
        'start_place_id',
        'name',
        'version',
        'privileges',
        'privacy',
        'unlisted'
    ];

    /**
     * The creator of this universe.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * The start place of this universe.
     */
    public function start_place()
    {
        return $this->belongsTo(Asset::class, 'start_place_id');
    }
}
