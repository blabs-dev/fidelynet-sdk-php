<?php

namespace Blabs\FidelyNet\Session\LoginStrategies;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiDeviceTypes;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Exceptions\FidelyNetSessionException;
use Blabs\FidelyNet\Responses\ApiResponse;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class CustomerLoginStrategy extends LoginStrategyAbstract
{
    const LOGIN_ACTION = ApiActions::LOGIN;

    /**
     * @inheritDoc
     *
     * @param array $credentials
     * @return string
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
     */
    protected function extractSessionId(ApiResponse $response): string
    {
        return $response->sessionid;
    }

    /**
     * Adds specifics Customer Service options to request data.
     *
     * @param $credentials
     *
     * @return array
     */
    #[ArrayShape(
        [
            'campaignid' => 'string',
            'username'   => 'string',
            'password'   => 'string',
            'devicetype' => 'string', ]
    )]
 private function prepareCredentials($credentials): array
 {
     return [
         'campaignid' => $credentials[FactoryOptions::CAMPAIGN_ID],
         'username'   => $credentials[FactoryOptions::USERNAME],
         'password'   => $credentials[FactoryOptions::PASSWORD],
         'devicetype' => ApiDeviceTypes::DESKTOP,
     ];
 }
}
