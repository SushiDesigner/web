<?php

namespace App\Roles;

/**
 * Economy permissions.
 */
class Economy
{
    /**
     * The name of this roleset.
     */
    public static function roleset()
    {
        return \App\Roles\Economy::class;
    }

    /**
     * Whether or not a user may comment on any given asset.
     */
    const COMMENTS = 1 << 0;

    /**
     * Whether or not a user may create a normal asset (shirt, pants, etc.)
     */
    const CREATE_ASSETS = 1 << 1;

    /**
     * If a user may delete *any* asset.
     */
    const GLOBAL_DELETE_ASSETS = 1 << 2;

    /**
     * If a user may re-render *any* asset.
     */
    const GLOBAL_FORCE_RENDER_ASSETS = 1 << 3;

    /**
     * If a user may perform LMaD functions on *any* asset.
     */
    const GLOBAL_LMAD = 1 << 4;

    /**
     * If a user may modify *any* assets description.
     */
    const GLOBAL_MODIFY_DESCRIPTION = 1 << 5;

    /**
     * If a user may modify *any* assets name.
     */
    const GLOBAL_MODIFY_NAME = 1 << 6;

    /**
     * If a user may modify *any* assets thumbnail.
     */
    const GLOBAL_MODIFY_THUMBNAIL = 1 << 7;

    /**
     * If a user may sell their own asset.
     */
    const SELL_ASSETS = 1 << 8;

    /**
     * Whether or not a user may upload faces.
     */
    const UPLOAD_FACES = 1 << 9;

    /**
     * Whether or not a user may upload gears.
     */
    const UPLOAD_GEARS = 1 << 10;

    /**
     * Whether or not a user may upload hats.
     */
    const UPLOAD_HATS = 1 << 11;

    /**
     * Whether or not a user may upload packages.
     */
    const UPLOAD_PACKAGES = 1 << 12;
}
