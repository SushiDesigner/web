<?php

namespace App\Roles;

/**
 * Self hosted server permissions.
 */
class SelfHostedServers
{
    /**
     * The name of this roleset.
     */
    public static function roleset()
    {
        return \App\Roles\SelfHostedServers::class;
    }

    /**
     * If a user is able to create a self hosted server.
     */
    const CREATION = 1 << 0;

    /**
     * If a user may delete *any* given self hosted server.
     */
    const GLOBAL_DELETION = 1 << 1;

    /**
     * If a use may modify the description of *any* given self hosted server.
     */
    const GLOBAL_MODIFY_DESCRIPTION = 1 << 2;

    /**
     * If a user may modify the thumbnail of *any* given self hosted server.
     */
    const GLOBAL_MODIFY_TITLE = 1 << 3;
}
