<?php

namespace App\Helpers;

use App\Models\IpAddressBan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class IpAddressBanManager
{
    /**
     * Loads all IP address bans into cache.
     */
    public static function refresh()
    {
        if (!Schema::hasTable('ip_address_bans'))
        {
            return;
        }

        $banned_ip_addresses = [];

        foreach (IpAddressBan::all() as $ban)
        {
            if (!$ban->is_active)
            {
                continue;
            }

            $banned_ip_addresses[] = $ban->ip_address;
        }

        Cache::store('octane')->put('banned_ip_addresses', $banned_ip_addresses);
    }
}
