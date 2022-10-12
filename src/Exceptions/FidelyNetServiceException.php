<?php

namespace Blabs\FidelyNet\Exceptions;

use Exception;

class FidelyNetServiceException extends Exception
{
    private string $responseBody;

    private int $serviceErrorCode;

    /**
     * @param string $message
     * @param string $responseBody
     */
    public function __construct(string $message, string $responseBody = '', $serviceErrorCode = 0)
    {
        parent::__construct($message);
        $this->responseBody = $responseBody;
        $this->serviceErrorCode = $serviceErrorCode;
    }

    /**
     * @return string
     */
    public function getResponseBody(): string
    {
        return $this->responseBody;
    }

    public function getServiceErrorCode(): ?int
    {
        return $this->serviceErrorCode;
    }
}
