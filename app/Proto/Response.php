<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: resources/tadah.proto

namespace App\Proto;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>Tadah.Response</code>
 */
class Response extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.Tadah.Operation operation = 1;</code>
     */
    protected $operation = 0;
    /**
     * Generated from protobuf field <code>bool success = 2;</code>
     */
    protected $success = false;
    /**
     * Generated from protobuf field <code>string message = 3;</code>
     */
    protected $message = '';
    /**
     * Generated from protobuf field <code>string data = 4;</code>
     */
    protected $data = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $operation
     *     @type bool $success
     *     @type string $message
     *     @type string $data
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Resources\Tadah::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.Tadah.Operation operation = 1;</code>
     * @return int
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Generated from protobuf field <code>.Tadah.Operation operation = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setOperation($var)
    {
        GPBUtil::checkEnum($var, \App\Proto\Operation::class);
        $this->operation = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bool success = 2;</code>
     * @return bool
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Generated from protobuf field <code>bool success = 2;</code>
     * @param bool $var
     * @return $this
     */
    public function setSuccess($var)
    {
        GPBUtil::checkBool($var);
        $this->success = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string message = 3;</code>
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Generated from protobuf field <code>string message = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setMessage($var)
    {
        GPBUtil::checkString($var, True);
        $this->message = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string data = 4;</code>
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Generated from protobuf field <code>string data = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setData($var)
    {
        GPBUtil::checkString($var, True);
        $this->data = $var;

        return $this;
    }

}
