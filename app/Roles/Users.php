<?php

namespace App\Roles;

/**
 * User permissions.
 */
class Users
{
    /**
     * The name of this roleset.
     */
    public static function roleset()
    {
        return \App\Roles\Users::class;
    }

    /**
     * If a user may modify *any* other users account balance.
     */
    const GLOBAL_MODIFY_MONEY = 1 << 0;

    /**
     * If a user may view *any* other users account balance.
     */
    const GLOBAL_SEE_MONEY = 1 << 1;

    /**
     * If a user is permitted to issue a ban on *any* other user.
     */
    const MODERATION_GENERAL_BAN = 1 << 2;

    /**
     * If a user is permitted to ban IP addresses.
     */
    const MODERATION_IP_ADDRESS_BAN = 1 << 3;

    /**
     * If a user is permitted to pardon bans.
     */
    const MODERATION_PARDON_BAN = 1 << 4;

    /**
     * If a user is permitted to pardon IP address bans.
     */
    const MODERATION_PARDON_IP_ADDRESS_BAN = 1 << 5;

    /**
     * If a user is permitted to issue a poison ban on *any* other user.
     */
    const MODERATION_POISON_BAN = 1 << 6;

    /**
     * If a user may view the associated accounts of *any* other user.
     */
    const MODERATION_VIEW_ASSOCIATED_ACCOUNTS = 1 << 7;

    /**
     * If a user may view the moderation history of *any* other user.
     */
    const MODERATION_VIEW_BAN_HISTORY = 1 << 8;

    /**
     * If a user may view *all bans ever* on the project.
     */
    const MODERATION_VIEW_BAN_LIST = 1 << 9;

    /**
     * If a user may view *all IP address bans ever* on the project.
     */
    const MODERATION_VIEW_IP_ADDRESS_BAN_LIST = 1 << 10;

    /**
     * If a user is allowed to have a more in-depth view on *any* other user.
     */
    const MODERATION_VIEW_USER_PROFILE = 1 << 11;

    /**
     * If a user is permitted to send, decline, and manage friendships of their own.
     */
    const SEND_FRIEND_REQUESTS = 1 << 12;

    /**
     * If a user is permitted to send and receieve private messages.
     */
    const SEND_MESSAGES = 1 << 13;

    /**
     * If a user is allowed to update their own blurb.
     */
    const UPDATE_BLURB = 1 << 14;

    /**
     * If a user is allowed to view their own moderation history.
     */
    const VIEW_BAN_HISTORY = 1 << 15;

    /**
     * If a user is allowed to purchase an invite key.
     */
    const PURCHASE_INVITE_KEY = 1 << 16;
}
