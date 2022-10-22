<?php

namespace App\Events;

use App\Helpers\IpAddressBanManager;

class IpAddressBanModified
{
    /**
     * Handles an IP address ban's modification by refreshing all IP address bans.
     */
    public function handle()
    {
        IpAddressBanManager::refresh();
    }
}
