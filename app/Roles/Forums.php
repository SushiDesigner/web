<?php

namespace App\Roles;

/**
 * Forum permissions.
 */
class Forums
{
    /**
     * The name of this roleset.
     */
    public static function roleset()
    {
        return \App\Roles\Forums::class;
    }

    /**
     * If a user may manage forum categories.
     */
    const MANAGE_CATEGORIES = 1 << 0;

    /**
     * If a user may reply to threads (while being respective of if they are locked or not.)
     */
    const CREATE_REPLIES = 1 << 1;

    /**
     * If a user may post a thread (while being respective of if the category is protected or not.)
     */
    const CREATE_THREADS = 1 << 2;

    /**
     * If a user may delete *any* post.
     */
    const GLOBAL_DELETE_POSTS = 1 << 3;

    /**
     * If a user may edit *any* post.
     */
    const GLOBAL_EDIT_POSTS = 1 << 4;

    /**
     * If a user may lock *any* thread.
     */
    const GLOBAL_LOCK_THREADS = 1 << 5;

    /**
     * If a user may prune all of another users posts.
     */
    const GLOBAL_PRUNE_USER_POSTS = 1 << 6;

    /**
     * If a user may sticky *any* thread.
     */
    const GLOBAL_STICKY_THREADS = 1 << 7;

    /**
     * If a user may create threads in *any* category, including restricted ones.
     */
    const GLOBAL_CREATE_THREADS = 1 << 8;
}
