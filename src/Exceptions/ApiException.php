<?php

namespace InvisionApi\Exceptions;

abstract class ApiException extends \Exception
{
    /**
     * Error code in IPS error code format
     * @link https://invisioncommunity.com/developers/rest-api
     * @var string
     */
    public $errorCode;

    /**
     * Error message. This is not a user friendly error message, see the documentation for error definitions
     * @link https://invisioncommunity.com/developers/rest-api
     * @var string
     */
    public $errorMessage;

    /**
     * IPS API exception handler
	 * @param string $errorCode Error code in IPS error code format
     * @param string $errorMessage Error message. This is not a user friendly error message, see the documentation for error definitions
     */
    public function __construct(?string $errorCode, ?string $errorMessage)
    {
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;

        parent::__construct($errorMessage);
    }
}