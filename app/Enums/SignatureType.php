<?php

namespace App\Enums;

use Illuminate\Support\Facades\Storage;
use \OpenSSLAsymmetricKey;

enum SignatureType : string
{
    case Roblox = 'roblox';
    case Arbiter = 'arbiter';

    /**
     * Gets the hash algorithm for this signature type.
     *
     * @return int
     */
    public function algorithm(): int
    {
        return match($this) {
            SignatureType::Roblox => OPENSSL_ALGO_SHA1,
            SignatureType::Arbiter => OPENSSL_ALGO_SHA256
        };
    }

    /**
     * Gets the key passphrase for this signature type.
     *
     * @return string
     * @throws \Exception
     */
    public function getPrivateKeyPassphrase(): string
    {
        $passphrase = match($this) {
            SignatureType::Roblox => env('ROBLOX_PRIVATE_KEY_PASSPHRASE'),
            SignatureType::Arbiter => env('ARBITER_PRIVATE_KEY_PASSPHRASE')
        };

        if (is_null($passphrase))
        {
            throw new \Exception('No passphrase set for key ' . $this->name);
        }

        return $passphrase;
    }

    /**
     * Gets the private key for this signature type.
     *
     * @return \OpenSSLAsymmetricKey
     * @throws \Exception
     */
    public function getPrivateKey(): \OpenSSLAsymmetricKey
    {
        $pem = match ($this) {
            SignatureType::Roblox => Storage::disk('local')->get('keys/roblox.pem'),
            SignatureType::Arbiter => Storage::disk('local')->get('keys/arbiter.pem')
        };

        $key = openssl_pkey_get_private($pem, $this->getPrivateKeyPassphrase());

        if ($key === false)
        {
            throw new \Exception('Failed to acquire private key');
        }

        return $key;
    }

    /**
     * Gets the public key for this signature type.
     *
     * @return string
     */
    public function getPublicKey(): string
    {
        return openssl_pkey_get_details($this->getPrivateKey())['key'];
    }
}
