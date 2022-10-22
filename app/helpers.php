<?php

use App\Helpers\Agent;
use App\Helpers\PaginationTransformer;
use App\Signing\Signer;
use App\Enums\SignatureType;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\CarbonInterval;
use Stevebauman\Location\Facades\Location;

if (!function_exists('seconds2human'))
{
    /**
     * Transforms a given amount of seconds into a human readable duration.
     *
     * @param int $seconds
     * @param bool $cascade
     * @return string
     */
    function seconds2human(int $seconds, bool $cascade = false): string
    {
        $interval = CarbonInterval::seconds($seconds);

        if ($cascade)
        {
            $interval = $interval->cascade();
        }

        return $interval->forHumans(['join' => true]);
    }
}

if (!function_exists('getInboxAddress'))
{
    /**
     * Returns the project's mail inbox address.
     *
     * @return string
     */
    function getInboxAddress(): string
    {
        return 'inbox@' . config('app.base_url');
    }
}

if (!function_exists('countryCodeToEmoji'))
{
    /**
     * Gets the flag emoji for a given country code.
     *
     * @param  string $country_code
     * @return string
     */
    function countryCodeToEmoji(string $country_code): string
    {
        $country_code = strtoupper($country_code);
        $flag = 0x1F1A5;

        $first = mb_convert_encoding('&#' . (ord($country_code[0]) + $flag) . ';', 'UTF-8', 'HTML-ENTITIES');
        $second = mb_convert_encoding('&#' . (ord($country_code[1]) + $flag) . ';', 'UTF-8', 'HTML-ENTITIES');

        return $first . $second;
    }
}

if (!function_exists('geolocate'))
{
    /**
     * Returns the country name, territory name, country code, and flag for a given IP address. If the IP address could not be successfully geolocated, returns false.
     *
     * @param  string      $ip_address
     * @return bool|object
     */
    function geolocate(string $ip_address): bool|object
    {
        if (($location = Location::get($ip_address)) !== false)
        {
            return (object) [
                'country' => $location->countryName,
                'territory' => $location->regionName,
                'countryCode' => $location->countryCode,
                'flag' => countryCodeToEmoji($location->countryCode)
            ];
        }

        return false;
    }
}

if (!function_exists('agent'))
{
    /**
     * Returns a new Agent for a given user agent string.
     *
     * @param  string $user_agent
     * @return \App\Helpers\Agent
     */
    function agent(string $user_agent): Agent
    {
        return new Agent(null, $user_agent);
    }
}

if (!function_exists('is_online'))
{
    /**
     * Checks if a given timestamp is "online".
     *
     * @param  int $timestamp
     * @return bool
     */
    function is_online(int $timestamp): bool
    {
        return time() - $timestamp <= 60;
    }
}

if (!function_exists('active_link'))
{
    /**
     * Returns whether or not to highlight a route in the navigation bar by comparing the current request route.
     *
     * @param string $route
     * @param int $segment
     * @return bool
     */
    function active_link(string $route, int $segment = 1): bool
    {
        return request()->segment($segment) == $route;
    }
}

if (!function_exists('paginate'))
{
    /**
     * Paginates a given collection.
     *
     * @param \Illuminate\Support\Collection $collection
     * @param int $show_per_page
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    function paginate(Collection $collection, int $show_per_page): LengthAwarePaginator
    {
        return PaginationTransformer::paginate($collection, $show_per_page);
    }
}

if (!function_exists('safe_define'))
{
    /**
     * Safely defines a constant by checking if it exists in the first place.
     *
     * @param string $key
     * @param mixed  $value
     */
    function safe_define(string $key, mixed $value)
    {
        if (!defined($key))
        {
            define($key, $value);
        }
    }
}

if (!function_exists('sha256'))
{
    /**
     * Returns a SHA256 checksum of given data.
     *
     * @param  mixed $data
     * @return string
     */
    function sha256(mixed $data): string
    {
        return hash('sha256', $data);
    }
}

if (!function_exists('sha512'))
{
    /**
     * Returns a SHA512 checksum of given data.
     *
     * @param  mixed $data
     * @return string
     */
    function sha512(mixed $data): string
    {
        return hash('sha512', $data);
    }
}

if (!function_exists('uuid'))
{
    /**
     * Returns a new randomly generated UUID.
     *
     * @return string
     */
    function uuid(): string
    {
        return Str::uuid()->toString();
    }
}

if (!function_exists('signer'))
{
    /**
     * Acquires a signer.
     *
     * @param SignatureType|string $type
     * @return Signer
     */
    function signer(SignatureType|string $type): Signer
    {
        if (is_string($type))
        {
            $type = SignatureType::tryFrom($type) ?? SignatureType::Roblox;
        }

        return new Signer($type);
    }
}

if (!function_exists('is_base64'))
{
    /**
     * Determines if a string is base64 or not.
     *
     * @param mixed $data
     * @return bool
     */
    function is_base64($data): bool
    {
        return base64_encode(base64_decode($data, true)) === $data;
    }
}

if (!function_exists('is_ipv4'))
{
    /**
     * Determines if a string is a valid IPv4 address.
     *
     * @param mixed $data
     * @return bool
     */
    function is_ipv4(mixed $data): bool
    {
        return filter_var($data, FILTER_VALIDATE_IP) && !filter_var($data, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }
}

if (!function_exists('is_port'))
{
    /**
     * Determines if a port is a valid port.
     *
     * @param mixed $data
     * @return bool
     */
    function is_port(mixed $data):bool
    {
        return is_numeric($data) && $data > 0 && $data < 65536;
    }
}
