<?php

namespace App\Signing;

use App\Enums\SignatureType;
use \OpenSSLAsymmetricKey;

class Signer
{
    /**
     * The signature type.
     *
     * @param SignatureType
     */
    public SignatureType $type;

    /**
     * The signer's private key.
     *
     * @param \OpenSSLAsymmetricKey
     */
    private OpenSSLAsymmetricKey $privateKey;

    /**
     * The signer's public key.
     *
     * @param string
     */
    private string $publicKey;

    /**
     * Creates a new signer.
     *
     * @param SignatureType $type
     */
    public function __construct(SignatureType $type)
    {
        $this->type = $type;

        $this->privateKey = $type->getPrivateKey();
        $this->publicKey = $type->getPublicKey();
    }

    /**
     * Signs data.
     *
     * @param string $data
     * @return Signature
     */
    public function sign(string $data): Signature
    {
        // $signature appears out of thin air!
        openssl_sign($data, $signature, $this->privateKey, $this->type->algorithm());

        return new Signature($signature, $this->type);
    }

    /**
     * Verifies data.
     *
     * @param string $data
     * @param string|Signature $signature
     */
    public function verify(string $data, string|Signature $signature)
    {
        if (is_string($signature))
        {
            $signature = new Signature($signature, $this->type);
        }

        return (bool) openssl_verify($data, $signature->raw, $this->publicKey);
    }
}
