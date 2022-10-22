<?php

namespace App\Enums;

enum Actions : int
{
    case TempBannedUser = 0;
    case PermBannedUser = 1;
    case PoisonBannedUser = 2;
    case WarnedUser = 3;
    case PardonedUser = 4;
    case CreatedGameServer = 5;
    case DeletedGameServer = 6;
    case ModifiedGameServer = 7;
    case AddIPBan = 8;
    case RemoveIPBan = 9;
    case SiteAlert = 10;
    case ApprovedAsset = 11;
    case DeniedAsset = 12;
    case ModeratedAsset = 13;
    case ChangedUserPermissions = 14;
    case DeletedThread = 15;
    case DeletedReply = 16;
    case CreatedCategory = 17;
    case ModifiedCategory = 18;
    case DeletedCategory = 19;
    case ToggleStickiedThread = 20;
    case EditedReply = 21;
    case EditedThread = 22;
    case PrunedPosts = 23;

    /**
     * Return the string for the action log type.
     *
     * @return string
     */
    public function text(): string
    {
        return match($this)
        {
            self::TempBannedUser => 'Temporarily banned :name until :date.',
            self::PermBannedUser => 'Permanently banned :name.',
            self::PoisonBannedUser => 'Poison banned :name.',
            self::WarnedUser => 'Warned :name.',
            self::PardonedUser => 'Pardoned :name.',
            self::CreatedGameServer => 'Created game server :ip.',
            self::DeletedGameServer => 'Deleted game server :ip.',
            self::ModifiedGameServer => 'Modified game server :ip.',
            self::AddIPBan => 'Added an IP ban.',
            self::RemoveIPBan => 'Removed an IP ban.',
            self::SiteAlert => 'Changed the site alert.',
            self::ApprovedAsset => 'Approved a :type: :name. (Asset ID: :id)',
            self::DeniedAsset => 'Denied a :type: :name. (Asset ID: :id)',
            self::ModeratedAsset => 'Moderated a :type: :name. (Asset ID: :id)',
            self::ChangedUserPermissions => 'Changed permissions for :name.',
            self::DeletedThread => 'Deleted thread :name. (Thread ID: :id)',
            self::DeletedReply => 'Deleted reply on :name. (Thread ID: :id)',
            self::CreatedCategory => 'Created the :name forum category.',
            self::ModifiedCategory => 'Modified the :name forum category.',
            self::DeletedCategory => 'Deleted the :name forum category.',
            self::ToggleStickiedThread => 'Toggled sticky status for thread :name. (Thread ID: :id)',
            self::EditedReply => 'Edited a reply on :name. (Thread ID: :id)',
            self::EditedThread => 'Edited thread :name. (Thread ID: :id)',
            self::PrunedPosts => 'Pruned all forum posts from :name.',
            default => $this->name
        };
    }
}
