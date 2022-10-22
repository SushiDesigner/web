<?php

use Illuminate\Support\Str;

return [
    // User invite key settings
    'users_create_invite_keys' => (bool) env('USERS_CREATE_INVITE_KEYS', true),
    'user_invite_key_cost' => 100,
    'user_maximum_keys_in_window' => 2, // for ex. 2 keys every x days
    'user_invite_key_cooldown' => 7, // in days

    'invite_keys_required' => (bool)env('REQUIRE_INVITE_KEYS', false),
    'currency_name' => Str::plural('Token'),
    'currency_name_singular' => 'Token',
    'discord_required' => (bool)env('USERS_DISCORD_REQUIRED', true),
    'username_change_cost' => 0,
];
