<?php

namespace App\Roles;

/**
 * Place permissions.
 */
class Places
{
    /**
     * The name of this roleset.
     */
    public static function roleset()
    {
        return \App\Roles\Places::class;
    }

    /**
     * If a user may create places.
     */
    const CREATION = 1 << 0;

    /**
     * If a user may delete *any* place.
     */
    const GLOBAL_DELETION = 1 << 2;

    /**
     * If a user may download *any* place file.
     */
    const GLOBAL_DOWNLOAD_FILE = 1 << 3;

    /**
     * If a user may moderate the icon of *any* place.
     */
    const GLOBAL_MODERATE_ICON = 1 << 4;

    /**
     * If a user may moderate the thumbnail of *any* place.
     */
    const GLOBAL_MODERATE_THUMBNAIL = 1 << 5;

    /**
     * If a user may modify the description of *any* place.
     */
    const GLOBAL_MODIFY_DESCRIPTION = 1 << 6;

    /**
     * If a user may modify the title of *any* place.
     */
    const GLOBAL_MODIFY_TITLE = 1 << 7;

    /**
     * If a user may manually shutdown any given job of *any* place.
     */
    const GLOBAL_CLOSE_JOBS = 1 << 8;

    /**
     * If a user may view the job ID of the running jobs of *any* place.
     */
    const SEE_JOB_ID = 1 << 9;

    /**
     * If a user is permitted to access the WatchDog features on *any* place.
     */
    const WATCHDOG = 1 << 10;
}
