<?php

namespace Blabs\FidelyNet\Exceptions;

use Exception;

class FidelyNetServiceException extends Exception
{
    private string $responseBody;

    /**
     * @param string $message
     * @param string $responseBody
     */
    public function __construct(string $message, string $responseBody = '')
    {
        parent::__construct($message);
        $this->responseBody = $responseBody;
    }

    /**
     * @return string
     */
    public function getResponseBody(): string
    {
        return $this->responseBody;
    }
}
