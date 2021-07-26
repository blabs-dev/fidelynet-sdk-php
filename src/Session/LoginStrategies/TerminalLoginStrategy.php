<?php

namespace Blabs\FidelyNet\Session\LoginStrategies;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Exceptions\FidelyNetSessionException;
use Blabs\FidelyNet\Responses\ApiResponse;
use Blabs\FidelyNet\Responses\ResponseData\LoginResponseData;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class TerminalLoginStrategy extends LoginStrategyAbstract
{
    const LOGIN_ACTION = ApiActions::LOGIN;

    /**
     * @inheritDoc
     *
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function startSession(array $credentials): string
    {
        $response = $this->client->actionRequest(self::LOGIN_ACTION, $this->prepareCredentials($credentials));

        return $this->extractSessionId($response);
    }

    /**
     * @inheritDoc
     *
     * @throws UnknownProperties
     */
    protected function extractSessionId(ApiResponse $response): string
    {
        $response_data = new LoginResponseData($response->data);

        return $response_data->sessionID;
    }

    /**
     * Adds specifics Terminal Service options to request data.
     */
    #[ArrayShape([
        'terminalserial' => 'string',
        'username'       => 'string',
        'password'       => 'string',
    ])]
 private function prepareCredentials($credentials): array
 {
     return [
         'terminalserial' => $credentials[FactoryOptions::TERMINAL],
         'username'       => $credentials[FactoryOptions::USERNAME],
         'password'       => $credentials[FactoryOptions::PASSWORD],
     ];
 }
}
