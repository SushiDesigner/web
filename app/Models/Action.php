<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Ban;
use App\Models\GameServer;
use App\Models\Asset;
use App\Enums\Actions;

use Laravel\Scout\Searchable;

class Action extends Model
{
    use Searchable;

	/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'doer_id',
        'action',
        'target_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'action' => Actions::class
    ];

    /**
     * Log an action by an administrator.
     * 
     * @var array
     */
    public static function log($user, $action, $target = null)
    {
        if ($target) {
            return self::create([
                'doer_id' => $user->id,
                'action' => $action->value,
                'target_id' => $target->id
            ]);
        } else {
            return self::create([
                'doer_id' => $user->id,
                'action' => $action->value
            ]);
        }
    }

    /**
     * The person who had done the action.
     */
    public function doer()
    {
        return $this->belongsTo(User::class, 'doer_id');
    }

    /**
     * The person who had done the action.
     */
    public function target()
    {
        return $this->belongsTo(User::class, 'action_user_id');
    }

    /**
     * Format the localized log string properly.
     */
    public function format()
    {
        $string = __($this->action->text());

        if ($this->action == Actions::WarnedUser ||
            $this->action == Actions::PermBannedUser ||
            $this->action == Actions::PoisonBannedUser ||
            $this->action == Actions::PardonedUser) {
            $user = User::where('id', '=', $this->target_id)->first();

            if ($user) {
                $name = $user->username;

                $string = __($this->action->text(), ['name' => $name]);
            } else {
                $string = __('Moderated a user.');
            }
        }

        if ($this->action == Actions::ChangedUserPermissions) {
            $user = User::where('id', '=', $this->target_id)->first();

            if ($user) {
                $name = $user->username;

                $string = __($this->action->text(), ['name' => $name]);
            } else {
                $string = __('Changed permissions for a user.');
            }
        }

        if ($this->action == Actions::TempBannedUser) {
            $ban = Ban::where('id', '=', $this->target_id)->first();

            if ($ban) {
                $name = $ban->user->username;
                $date = $ban->expiry_date;

                $string = __($this->action->text(), ['name' => $name, 'date' => $date]);
            } else {
                $string = __('Moderated a user.');
            }
        }

        if ($this->action == Actions::CreatedGameServer ||
            $this->action == Actions::DeletedGameServer ||
            $this->action == Actions::ModifiedGameServer) {
            $gameServer = GameServer::where('id', '=', $this->target_id)->withTrashed()->first();

            if ($gameServer) {
                $ip_address = $gameServer->ip_address;

                $string = __($this->action->text(), ['ip' => $ip_address]);
            } else {
                $string = __('Modified a game server.');
            }
        }

        if ($this->action == Actions::ApprovedAsset ||
            $this->action == Actions::DeniedAsset ||
            $this->action == Actions::ModeratedAsset) {
            $asset = Asset::where('id', '=', $this->target_id)->withTrashed()->first();

            if ($asset) {
                $name = $asset->name;
                $type = $asset->type;
                $id = $asset->id;

                $string = __($this->action->text(), ['name' => $name, 'type' => $type, 'id' => $id]);
            } else {
                $string = __('Modified an asset.');
            }
        }

        return $string;
    }

    public function toSearchableArray()
    {
        return [ 'username' => $this->doer->username ];
    }
}
