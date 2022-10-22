<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetOwnership extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'asset_id',
        'user_id',
        'wearing'
    ];

    /**
     * Gets the asset that's owned.
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    /**
     * Gets the user that owns the asset.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
