<?php

namespace App\Cdn;

class Manager
{
    /**
     * Returns whether or not a given hash exists in the CDN file database.
     *
     * @param  string $hash
     * @return bool
     */
    public static function hasHashedFile(string $hash): bool
    {
        return false;
    }

    /**
     * Fetches the data of a hashed file in the CDN file database.
     *
     * @param  string $hash
     * @return mixed
     */
    public static function fetchHashedFile(string $hash): mixed
    {
        return null;
    }

    /**
     * Returns whether a given asset ID exists in the CDN file database.
     *
     * @param  int $id
     * @return bool
     */
    public static function hasAssetId(int $id): bool
    {
        return false;
    }

    /**
     * Fetches the data of a asset ID in the CDN file database.
     *
     * @param  int $id
     * @return mixed
     */
    public static function fetchAssetId(int $id): mixed
    {
        return null;
    }
}
