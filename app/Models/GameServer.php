<?php

namespace App\Models;

use App\Roles\GameServers;
use App\Enums\GameServerState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use BjornVoesten\CipherSweet\Concerns\WithAttributeEncryption;
use BjornVoesten\CipherSweet\Casts\Encrypted as CipherSweetEncrypted;

use Log;

class GameServer extends Model
{
    use SoftDeletes, WithAttributeEncryption;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'access_key',
        'ip_address',
        'port',
        'maximum_place_jobs',
        'maximum_thumbnail_jobs',
        'is_set_up',
        'has_vnc',
        'vnc_port',
        'vnc_password',
        'friendly_name',
        'utc_offset',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'access_key',
        'access_key_index',
        'ip_address',
        'ip_address_index',
        'vnc_port',
        'vnc_password',
        'friendly_name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'access_key' => CipherSweetEncrypted::class,
        'ip_address' => CipherSweetEncrypted::class,
        'vnc_port' => 'encrypted',
        'vnc_password' => 'encrypted',
        'friendly_name' => 'encrypted',
    ];

    /**
     * Unformatted log keys for any game server.
     *
     * @return array
     */
    public static array $logKeys = [
        'console' => 'game_server_logs_%s',
        'ram' => 'game_server_ram_usage_%s',
        'cpu' => 'game_server_cpu_usage_%s',
        'network' => 'game_server_network_usage_%s',
        'access' => 'game_server_access_%s',
        'state' => 'game_server_state_%s',
    ];

    /**
     * Gets a log key associated for this game server.
     *
     * @param string $key
     * @return ?string
     */
    public function logKey(string $key): ?string
    {
        if (empty(self::$logKeys[$key]))
        {
            return null;
        }

        return sprintf(self::$logKeys[$key], $this->uuid);
    }

    /**
     * Initializes all logs keys.
     */
    public function initLogKeys()
    {
        foreach (array_keys(self::$logKeys) as $key)
        {
            Cache::put($this->logKey($key), null);
        }
    }

    /**
     * Updates the state last ping.
     */
    public function ping()
    {
        Cache::put($this->logKey('state'), [
            'last_ping' => time(),
            'state' => GameServerState::Online
        ]);
    }

    /**
     * The complete log of this game server.
     *
     * @param  string $key
     * @return mixed
     */
    public function retrieveCompleteLog(string $key): mixed
    {
        return Cache::get($this->logKey($key));
    }

    /**
     * Appends to one of the log files of this game server.
     *
     * @param string $key
     * @param mixed  $message
     */
    public function appendToLog(string $key, mixed $message)
    {
        $lock = Cache::lock($this->logKey($key), 10);

        try
        {
            $lock->block(5);

            $log = $this->retrieveCompleteLog($key);
            if (empty($log))
            {
                $log = [];
            }

            $timestamp = time();

            $log['latest'] = $timestamp;
            $log[$timestamp] = $message;

            Cache::put($this->logKey($key), $log);

            $lock->release();
        }
        finally
        {
            optional($lock)->release();
        }
    }

    /**
     * Gets the latest log entry of this game server for a given key.
     *
     * @param  string $key
     * @return mixed
     */
    public function getLatestLogEntry(string $key): mixed
    {
        $log = $this->retrieveCompleteLog($key);

        return $log[$log['latest']];
    }

    /**
     * Wipes all the logs of this game server.
     */
    public function wipeLogs()
    {
        foreach (array_keys(self::$logKeys) as $key)
        {
            Cache::forget($this->logKey($key));
        }

        $this->initLogKeys();
    }

    /**
     * Wipes a specific log file for this game server.
     *
     * @param string $key
     */
    public function wipeLog(string $key)
    {
        Cache::forget($this->logKey($key));
    }

    /**
     * The places this game server is allowed to access.
     *
     * @return array
     */
    public function allowedPlaces(): array
    {
        return Cache::get($this->logKey('access')) ?? [];
    }

    /**
     * Allows this game server to access a place.
     *
     * @param int $place_id
     */
    public function allow(int $place_id)
    {
        $access = $this->allowedPlaces();
        $access[] = $place_id;

        Cache::store($this->logKey('access'));
    }

    /**
     * Gets the current state of this game server.
     *
     * @return GameServerState
     */
    public function state(): GameServerState
    {
        if (is_null($state = Cache::get($this->logKey('state'))))
        {
            $this->setState(GameServerState::Offline);
            return GameServerState::Offline;
        }

        if ($state['state'] == GameServerState::Online && (time() - $state['last_ping']) >= 60)
        {
            $this->setState(GameServerState::Offline);
            return GameServerState::Offline;
        }

        return $state['state'];
    }

    /**
     * Sets the current state of this game server.
     *
     * @param GameServerState $state
     */
    public function setState(GameServerState $state)
    {
        if ($state == GameServerState::Offline)
        {
            $this->wipeLogs();
        }

        Cache::put($this->logKey('state'), [
            'last_ping' => time(),
            'state' => $state
        ]);
    }

    /**
     * Gets all running place jobs of this game server.
     *
     * @return array
     */
    public function getRunningPlaceJobs(): array
    {
        return [];
    }

    /**
     * Gets all running thumbnail jobs of this game server.
     *
     * @return array
     */
    public function getRunningThumbnailJobs(): array
    {
        return [];
    }

    /**
     * Generates a random access key.
     *
     * @return string
     */
    public static function generateAccessKey(): string
    {
        return bin2hex(random_bytes(32));
    }
}
