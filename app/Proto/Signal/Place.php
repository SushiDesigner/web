<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: resources/tadah.proto

namespace App\Proto\Signal;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>Tadah.Signal.Place</code>
 */
class Place extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>uint32 placeId = 1;</code>
     */
    protected $placeId = 0;
    /**
     * Generated from protobuf field <code>string script = 2;</code>
     */
    protected $script = '';
    /**
     * Generated from protobuf field <code>uint32 expirationInSeconds = 3;</code>
     */
    protected $expirationInSeconds = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $placeId
     *     @type string $script
     *     @type int $expirationInSeconds
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Resources\Tadah::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>uint32 placeId = 1;</code>
     * @return int
     */
    public function getPlaceId()
    {
        return $this->placeId;
    }

    /**
     * Generated from protobuf field <code>uint32 placeId = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setPlaceId($var)
    {
        GPBUtil::checkUint32($var);
        $this->placeId = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string script = 2;</code>
     * @return string
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * Generated from protobuf field <code>string script = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setScript($var)
    {
        GPBUtil::checkString($var, True);
        $this->script = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>uint32 expirationInSeconds = 3;</code>
     * @return int
     */
    public function getExpirationInSeconds()
    {
        return $this->expirationInSeconds;
    }

    /**
     * Generated from protobuf field <code>uint32 expirationInSeconds = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setExpirationInSeconds($var)
    {
        GPBUtil::checkUint32($var);
        $this->expirationInSeconds = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Place::class, \App\Proto\Signal_Place::class);
