<?php


namespace Blabs\FidelyNet\Session\LoginStrategies;


use Blabs\FidelyNet\Client;
use Blabs\FidelyNet\Responses\ApiResponse;

abstract class LoginStrategyAbstract
{
    /**
     * Current service instance's Client
     *
     * @var Client
     */
    public $client;

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
     * Start the session on the service
     *
     * @param array $credentials
     * @return string
     */
    abstract function startSession(array $credentials) :string;

    /**
     * Parse the service response to extract session id
     *
     * @param ApiResponse $response
     * @return string
     */
    protected abstract function extractSessionId(ApiResponse $response) :string;
}
