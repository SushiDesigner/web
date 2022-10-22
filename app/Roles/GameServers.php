<?php

namespace App\Roles;

/**
 * Game server permissions.
 */
class GameServers
{
    /**
     * The name of this roleset.
     */
    public static function roleset()
    {
        return \App\Roles\GameServers::class;
    }

    /**
     * If a user may close *any* job for *any* given game server.
     */
    const CLOSE_JOB = 1 << 0;

    /**
     * If a user may connect to the game server for real-time status updates.
     */
    const CONNECT = 1 << 1;

    /**
     * If a user may create game servers.
     */
    const CREATE = 1 << 2;

    /**
     * If a user may execute scripts on *any* given game servers job.
     */
    const EXECUTE_SCRIPT = 1 << 3;

    /**
     * If a user may manage or modify *any* game server.
     */
    const MANAGE = 1 << 4;

    /**
     * If a user may manually start a job on *any* game server (for debugging purposes.)
     */
    const MANUALLY_START_JOB = 1 << 5;

    /**
     * If a user may modify the priority of *any* given game server.
     */
    const MODIFY_PRIORITY = 1 << 6;

    /**
     * If a user may pause *any* game server.
     */
    const PAUSE = 1 << 7;

    /**
     * If a user may restart the host machine of *any* given game server.
     */
    const RESTART_MACHINE = 1 << 8;

    /**
     * If a user may shutdown the host machine of *any* given game server.
     */
    const SHUTDOWN_MACHINE = 1 << 9;

    /**
     * If a user may view *any* game server's details.
     */
    const VIEW = 1 << 10;

    /**
     * If a user may view the chat logs of *any* job on a given game server.
     */
    const VIEW_CHAT_LOGS = 1 << 11;

    /**
     * If a user may view Arbiter or RCCService crash logs on a given game server.
     */
    const VIEW_CRASH_LOGS = 1 << 12;

    /**
     * If a user may view older logs (either crash logs, chat logs, etc.) on *any* given game server.
     */
    const VIEW_PAST_LOGS = 1 << 13;

    /**
     * If a user may view the Roblox Console output on *any* given job running on *any* game server.
     */
    const VIEW_ROBLOX_CONSOLE = 1 << 14;

    /**
     * If a user may view VNC details.
     */
    const VIEW_VNC = 1 << 15;

    /**
     * If a user may delete a game server.
     */
    const DELETION = 1 << 16;
}
