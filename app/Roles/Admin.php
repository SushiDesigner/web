<?php

namespace App\Roles;

/**
 * Admin permissions.
 */
class Admin
{
    /**
     * The name of this roleset.
     */
    public static function roleset()
    {
        return \App\Roles\Admin::class;
    }

    /**
     * Whether or not a user may view the admin panel.
     */
    const VIEW_PANEL = 1 << 0;
}
