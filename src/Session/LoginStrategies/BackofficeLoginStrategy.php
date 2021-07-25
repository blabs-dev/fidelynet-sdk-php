<?php


namespace Blabs\FidelyNet\Session\LoginStrategies;


use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Responses\ApiResponse;

final class BackofficeLoginStrategy extends LoginStrategyAbstract
{
    const LOGIN_ACTION = ApiActions::LOGINBO;

    /**
     * @inheritDoc
     */
    function startSession(array $credentials): string
    {
        $response = $this->client->actionRequest(self::LOGIN_ACTION, $credentials);
        return $this->extractSessionId($response);
    }


    /**
     * @inheritDoc
     */
    protected function extractSessionId(ApiResponse $response) :string
    {
        return $response->sessionid;
    }
}
