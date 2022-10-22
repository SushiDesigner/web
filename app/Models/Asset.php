<?php

namespace App\Models;

use App\Enums\CreatorType;
use App\Enums\AssetType;
use App\Enums\AssetGenre;
use App\Helpers\Cdn;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;

class Asset extends Model
{
    use SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'genre',
        'version_id',
        'image_id',
        'creator_id',
        'creator_type',
        'is_for_sale',
        'is_public_domain',
        'comments_enabled',
        'moderation',
        'price',
        'gear_attributes',
        'sales',
        'favorites',
        'upvotes',
        'downvotes',

        'universe_id',
        'max_players',
        'client_version',
        'access',
        'chat_style',
        'is_start_place',
        'is_boosters_club_only',
        'visits'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'type' => AssetType::class,
        'genre' => AssetGenre::class,
        'creator_type' => CreatorType::class,
    ];

    /**
     * Gets the creator of this asset.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Gets the current version of this asset.
     */
    public function version()
    {
        return $this->belongsTo(AssetVersion::class, 'version_id');
    }

    /**
     * Gets all the versions of this asset.
     */
    public function versions()
    {
        return $this->hasMany(AssetVersion::class, 'asset_id');
    }

    /**
     * Gets all the comments of this asset.
     */
    public function comments()
    {
        return $this->hasMany(AssetComment::class, 'asset_id');
    }

    /**
     * Gets all the owners of this asset.
     */
    public function owners()
    {
        return $this->hasMany(AssetOwnership::class, 'asset_id');
    }

    /**
     * Gets the asset ownership info of the current user.
     *
     * @return AssetOwnership
     */
    public function ownership(): AssetOwnership
    {
        $userId = Auth::user()->id;
        return $this->owners()->where('user_id', $userId)->first();
    }

    /**
     * Checks if the current user can configure the asset.
     *
     * @return bool
     */
    public function canConfigure(): bool
    {
        if ($this->creator_type == CreatorType::User)
        {
            return $this->creator_id == Auth::user()->id;
        }

        return false;
    }

    /**
     * Initializes the asset on creation.
     *
     * @param string $file
     * @param ?string $thumbnail_icon
     */
    public function initialize(string $file, string $thumbnail_icon = null)
    {
        $this->createVersion($file, $thumbnail_icon);
        $this->addOwner(Auth::user()->id);
    }

    /**
     * Creates a new version of the asset.
     * A render request is made if no thumbnail icon is provided.
     *
     * @param string $file
     * @param ?string $thumbnail_icon
     * @return AssetVersion
     */
    public function createVersion(string $file, string $thumbnail_icon = null): AssetVersion
    {
        $cdn_file_hash = Cdn::hash($file);
        $cdn_thumbnail_icon_hash = Cdn::hash($thumbnail_icon);

        $lastVersion = AssetVersion::select('version')->where('asset_id', $this->id)->orderByDesc('id')->limit(1)->value('version') ?? 0;

        $assetVersion = AssetVersion::create([
            'asset_id' => $this->id,
            'version' => $lastVersion + 1,
            'cdn_file_hash' => $cdn_file_hash,
            'cdn_thumbnail_icon_hash' => $cdn_thumbnail_icon_hash
        ]);

        $this->update(['version_id' => $assetVersion->id]);

        // TODO: request thumbnail render if icon hash is not provided

        return $assetVersion;
    }

    /**
     * Adds a new owner of the asset.
     *
     * @param int $user_id
     * @return AssetOwnership
     */
    public function addOwner(int $user_id): AssetOwnership
    {
        return AssetOwnership::create([
            'asset_id' => $this->id,
            'user_id' => $user_id
        ]);
    }
}
