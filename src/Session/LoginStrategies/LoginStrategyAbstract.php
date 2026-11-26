<?php

namespace Blabs\FidelyNet\Session\LoginStrategies;

use Blabs\FidelyNet\Client;
use Blabs\FidelyNet\Responses\ApiResponse;
use Blabs\FidelyNet\Responses\ResponseData\LoginResponseData;

abstract class LoginStrategyAbstract
{
    /**
     * Current service instance's Client.
     *
     * @var Client
     */
    public Client $client;

    /**
     * The parsed reply of the last login, for strategies whose login returns
     * more than a session id (the terminal one: operator and profile).
     *
     * @var LoginResponseData|null
     */
    protected ?LoginResponseData $loginResponse = null;

    /**
     * LoginStrategyContract constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Start the session on the service.
     *
     * @param array $credentials
     *
     * @return string
     */
    abstract public function startSession(array $credentials): string;

    /**
     * Parse the service response to extract session id.
     *
     * @param ApiResponse $response
     *
     * @return string
     */
    abstract protected function extractSessionId(ApiResponse $response): string;

    /**
     * The parsed reply of the last login made by this strategy, if any.
     *
     * @return LoginResponseData|null
     */
    public function getLoginResponse(): ?LoginResponseData
    {
        return $this->loginResponse;
    }
}
