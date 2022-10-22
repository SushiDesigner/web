<?php

namespace App\Discord;

use Illuminate\Support\Facades\Http;

class User
{
    /**
     * The user's Discord ID.
     */
    public int $id;

    /**
     * The user's username.
     */
    public string $username;

    /**
     * The user's 4-digit Discord tag.
     */
    public string $discriminator;

    /**
     * The user's avatar hash.
     */
    public string $avatar;

    /**
     * The user's avatar image URL.
     */
    public string $avatarUrl;

    /**
     * Gets the Discord profile of a given Discord user snowflake.
     *
     * @param int $discord_id
     */
    public function __construct(int $discord_id)
    {
        $data = Http::withHeaders(['Authorization' => sprintf('Bot: %s', env('DISCORD_BOT_TOKEN'))])
            ->get(sprintf('https://discord.com/api/v9/users/%d', $discord_id));

        $data = json_decode($data);

        $this->id = $data->id;
        $this->username = $data->username;
        $this->discriminator = $data->discriminator;
        $this->avatar = $data->avatar;
        $this->avatarUrl = sprintf('https://cdn.discordapp.com/avatars/%d/%s', $discord_id, $data->avatar);
    }
}
