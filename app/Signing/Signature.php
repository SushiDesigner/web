<?php

namespace App\Signing;

use App\Enums\SignatureType;

class Signature
{
    /**
     * The raw signature data.
     *
     * @param string
     */
    public string $raw;

    /**
     * The signature type.
     *
     * @param SignatureType $type
     */
    public SignatureType $type;

    /**
     * Creates a new signature.
     *
     * @param mixed $signature
     * @param SignatureType $type
     */
    public function __construct(mixed $signature, SignatureType $type)
    {
        if (is_base64($signature))
        {
            $signature = base64_decode($signature);
        }

        $this->raw = $signature;
        $this->type = $type;
    }

    /**
     * As a Roblox comment.
     *
     * @return string
     */
    public function asRobloxComment(): string
    {
        return ('--rbxsig' . str($this)->wrap('%'));
    }

    /**
     * As a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return base64_encode($this->raw);
    }
}
