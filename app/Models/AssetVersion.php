<?php

namespace App\Models;

use App\Helpers\Cdn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AssetVersion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'asset_id',
        'version',
        'cdn_thumbnail_icon_hash',
        'cdn_thumbnail_widescreen_hash',
        'cdn_file_hash'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'cdn_thumbnail_icon_hash',
        'cdn_thumbnail_widescreen_hash',
        'cdn_file_hash'
    ];

    /**
     * The asset associated with this version.
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    /**
     * The thumbnail of this version.
     * 
     * @param bool $widescreen
     * @return string
     */
    public function thumbnail(bool $widescreen = false): string
    {
        return Cdn::getUrl(sprintf('%s.png', $this->cdn_thumbnail_icon_hash), $widescreen);
    }
}
