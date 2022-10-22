<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetComment extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'asset_id',
        'creator_id',
        'content'
    ];

    /**
     * The asset associated with this comment.
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    /**
     * The user associated with this comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
