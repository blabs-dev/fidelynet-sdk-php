<?php

namespace Blabs\FidelyNet\Session\LoginStrategies;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Responses\ApiResponse;
use Blabs\FidelyNet\Responses\ResponseData\LoginResponseData;

final class TerminalLoginStrategy extends LoginStrategyAbstract
{
    const LOGIN_ACTION = ApiActions::LOGIN;

    /**
     * @inheritDoc
     */
    public function startSession(array $credentials): string
    {
        $response = $this->client->actionRequest(self::LOGIN_ACTION, $this->prepareCredentials($credentials));

        return $this->extractSessionId($response);
    }

    /**
     * @inheritDoc
     */
    protected function extractSessionId(ApiResponse $response): string
    {
        $response_data = new LoginResponseData($response->data);

        return $response_data->sessionID;
    }

    /**
     * Adds specifics Terminal Service options to request data.
     */
    private function prepareCredentials($credentials)
    {
        return [
            'terminalserial' => $credentials[FactoryOptions::TERMINAL],
            'username'       => $credentials[FactoryOptions::USERNAME],
            'password'       => $credentials[FactoryOptions::PASSWORD],
        ];
    }
}
