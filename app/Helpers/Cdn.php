<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Cdn
{
    /**
     * The algorithm that's being used to calculate file hashes.
     */
    private static $algo = 'sha256';

    /**
     * Shorthand for PHP's hash function with the CDN's configured hash algo
     *
     * @param string $data
     * @return string|false
     */
    public static function hash(string $data): string|false
    {
        return hash(self::$algo, $data);
    }

    /**
     * Shorthand for PHP's hash_file function with the CDN's configured hash algo
     *
     * @param string $filename
     * @return string|false
     */
    public static function hash_file(string $filename): string|false
    {
        return hash_file(self::$algo, $filename);
    }

    /**
     * Uploads a file to the app's configured content delivery system
     *
     * @param string $folder
     * @param string $data
     * @param ?string $extension
     * @return void
     */
    public static function save(string $data, ?string $extension = null): void
    {
        $filename = self::hash($data);

        if (!is_null($extension))
        {
            $filename = sprintf('%s.%s', $filename, $extension);
        }

        if (!Storage::disk('content')->exists($filename))
        {
            Storage::disk('content')->put($filename, $data);
        }
    }

    /**
     * Retrieves an accessible URL to a file on the app's configured content delivery system.
     * The widescreen parameter is used for the placeholder thumbnail on failure.
     *
     * @param string $folder
     * @param string $filename
     * @param bool $widescreen
     * @return string
     */
    public static function getUrl(string $filename, bool $widescreen = false): string
    {
        if (Storage::disk('content')->exists($filename))
        {
            return asset(sprintf('content/%s', $filename));
        }

        if ($widescreen)
        {
            return asset('img/placeholder/widescreen.png');
        }

        return asset('img/placeholder/icon.png');
    }
}
