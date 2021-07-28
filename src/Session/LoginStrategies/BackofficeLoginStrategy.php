<?php

namespace Blabs\FidelyNet\Session\LoginStrategies;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Exceptions\FidelyNetSessionException;
use Blabs\FidelyNet\Responses\ApiResponse;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class BackofficeLoginStrategy extends LoginStrategyAbstract
{
    const LOGIN_ACTION = ApiActions::BO_LOGIN;

    /**
     * @inheritDoc
     *
     * @param array $credentials
     *
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     *
     * @return string
     */
    public function startSession(array $credentials): string
    {
        $response = $this->client->actionRequest(self::LOGIN_ACTION, $credentials);

        return $this->extractSessionId($response);
    }

    /**
     * @inheritDoc
     */
    protected function extractSessionId(ApiResponse $response): string
    {
        return $response->sessionid;
    }
}
