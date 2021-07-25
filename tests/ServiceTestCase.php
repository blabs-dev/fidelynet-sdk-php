<?php

declare(strict_types=1);
/**
 * Copyright (c) B@Labs srl 2021.
 *
 * @category Tests
 *
 * @author   Salvo Bonanno <s.bonanno@blabs.it>
 * @license  https://opensource.org/licenses/MIT MIT
 *
 * @link     https://www.blabs.it
 */

namespace Blabs\FidelyNet\Test;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiDemoData;
use Blabs\FidelyNet\Constants\ApiMessages;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\ApiSessionTypes;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Services\BackofficeService;
use Blabs\FidelyNet\Services\CustomerService;
use Blabs\FidelyNet\Services\TerminalService;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ServiceTestCase extends TestCase
{
    // region TEST OPTIONS
    /**
     * If true tests that performs http requests will use a mock http client that will fake service responses.
     *
     * @var bool
     */
    public $mock_client_enabled = true;

    /**
     * If true tests that performs requests to FNET3 service will automatically be run in the DEMO environment.
     *
     * @var bool
     */
    public $enable_demo_environment = true;

    /**
     * If true tests that performs requests to FNET3 service will use a "persistent" session manager
     * The session id will be persisted across multiple requests of the same service (until it expires).
     *
     * @var bool
     */
    public $enable_persistent_session = false;
    // endregion

    // region TEST CREDENTIALS
    /**
     * A set of valid credentials used to login against the FNET3 Backoffice service.
     *
     * @var array
     */
    protected $backoffice_demo_credentials = [
        FactoryOptions::USERNAME => ApiDemoData::BACKOFFICE_USER,
        FactoryOptions::PASSWORD => ApiDemoData::BACKOFFICE_PASSWORD,
    ];
    /**
     * A set of valid credentials used to login against the FNET3 Terminal service.
     *
     * @var array
     */
    protected $terminal_demo_credentials = [
        FactoryOptions::USERNAME => ApiDemoData::TERMINAL_USERNAME,
        FactoryOptions::PASSWORD => ApiDemoData::TERMINAL_PASSWORD,
        FactoryOptions::TERMINAL => ApiDemoData::TERMINAL_SERIAL,
    ];
    /**
     * A set of valid credentials used to login against the FNET3 Customer service.
     *
     * @var array
     */
    protected $customer_demo_credentials = [
        FactoryOptions::USERNAME    => ApiDemoData::CUSTOMER_USERNAME,
        FactoryOptions::PASSWORD    => ApiDemoData::CUSTOMER_PASSWORD,
        FactoryOptions::CAMPAIGN_ID => ApiDemoData::CAMPAIGN_ID,
    ];
    // endregion

    // region FACTORY OPTIONS DATA

    /**
     * Return a set of valid options to create an instance of the Customer Service
     * in DEMO environment and using *non persistent* session manager.
     *
     * @return array
     */
    protected function getCustomerServiceDemoFactoryOptions()
    {
        return [
            FactoryOptions::DEMO_MODE        => $this->enable_demo_environment,
            FactoryOptions::SESSION_PERSISTS => $this->enable_persistent_session,
            FactoryOptions::USERNAME         => $this->customer_demo_credentials[FactoryOptions::USERNAME],
            FactoryOptions::PASSWORD         => $this->customer_demo_credentials[FactoryOptions::PASSWORD],
            FactoryOptions::CAMPAIGN_ID      => $this->customer_demo_credentials[FactoryOptions::CAMPAIGN_ID],
        ];
    }

    /**
     * Return a set of valid options to create an instance of the Customer Service
     * with a PUBLIC session type (usually used to register new customers)
     * in DEMO environment and using *non persistent* session manager.
     *
     * @return array
     */
    protected function getCustomerServicePublicSessionFactoryOptions()
    {
        return [
            FactoryOptions::DEMO_MODE        => $this->enable_demo_environment,
            FactoryOptions::SESSION_PERSISTS => $this->enable_persistent_session,
            FactoryOptions::SESSION_TYPE     => ApiSessionTypes::PUBLIC,
            FactoryOptions::CAMPAIGN_ID      => $this->customer_demo_credentials[FactoryOptions::CAMPAIGN_ID],
        ];
    }

    /**
     * Return a set of valid options to create an instance of the Backoffice Service
     * in DEMO environment and using *non persistent* session manager.
     *
     * @return array
     */
    protected function getBackofficeServiceDemoFactoryOptions()
    {
        return [
            FactoryOptions::DEMO_MODE        => $this->enable_demo_environment,
            FactoryOptions::SESSION_PERSISTS => $this->enable_persistent_session,
            FactoryOptions::USERNAME         => $this->backoffice_demo_credentials[FactoryOptions::USERNAME],
            FactoryOptions::PASSWORD         => $this->backoffice_demo_credentials[FactoryOptions::PASSWORD],
        ];
    }

    /**
     * Return a set of valid options to create an instance of the Terminal Service
     * in DEMO environment and using *non persistent* session manager.
     *
     * @return array
     */
    protected function getTerminalServiceDemoFactoryOptions()
    {
        return [
            FactoryOptions::DEMO_MODE        => $this->enable_demo_environment,
            FactoryOptions::SESSION_PERSISTS => $this->enable_persistent_session,
            FactoryOptions::USERNAME         => $this->terminal_demo_credentials[FactoryOptions::USERNAME],
            FactoryOptions::PASSWORD         => $this->terminal_demo_credentials[FactoryOptions::PASSWORD],
            FactoryOptions::TERMINAL         => $this->terminal_demo_credentials[FactoryOptions::TERMINAL],
        ];
    }

    // endregion

    // region FAKE RESPONSES UTILITIES

    /**
     * Fake an error response by FNET3 service,
     * if an error code is provided will be returned by the method, otherwise a random one will be chosen.
     *
     * @param null $error_code The error code to be returned
     *
     * @return string
     */
    protected function getFakeErrorResponse($error_code = null): string
    {
        $error_code = $error_code ?: array_rand(ApiMessages::CODES);
        return '{ "returncode": '.$error_code.', "data": { "answerCode": 0, "sessionID": "a0aa0a00-0000-0aaa-a000-aa0a0ca00000" } }';
    }

    /**
     * Fake a 'bad request' error response by FNET3 service
     * This kind of error is usually returned when request data are malformed.
     *
     * @return string
     */
    protected function getFakeBadRequestResponse(): string
    {
        return file_get_contents(dirname(__FILE__).'/json/errors/bad_request.json');
    }

    /**
     * Fake an 'expired session' response by FNET3 service.
     *
     * @return string
     */
    protected function getFakeExpiredSessionResponse(): string
    {
        return file_get_contents(dirname(__FILE__).'/json/errors/expired_session.json');
    }

    /**
     * Returns content of the chosen .json file in the /json folder to fake FNET3 service responses content
     * File is selected passing to the method the service type (corresponding the folder)
     * and action name (corresponding the file name), if present a suffix is added automatically.
     *
     * A file must be present in the folder in order to use it.
     *
     * @param string $service_type The service type to fake
     * @param string $action       The service's action to fake
     *
     * @return string The response body
     */
    protected function getFakeResponse($service_type, $action, $suffix = null)
    {
        $filename = $suffix === null ? "{$action}.json" : "{$action}-{$suffix}.json";
        $filepath = dirname(__FILE__)."/json/{$service_type}/{$filename}";

        if (!file_exists($filepath)) {
            throw new InvalidArgumentException('There is currently no example response .json file for this service action');
        }

        return file_get_contents($filepath);
    }

    /**
     * Fake a login response of the FNET3 services
     * The response content is manipulated to always return a unique id.
     *
     * @param string $service The service type to fake
     *
     * @return false|string
     */
    protected function getFakeLoginResponse(string $service)
    {
        switch ($service) {
        default:
        case ApiServices::TERMINAL:
            $response_content = $this->getFakeResponse(ApiServices::TERMINAL, ApiActions::LOGIN);
            $response_data = json_decode($response_content, true);
            $response_data['data']['sessionID'] = uniqid();

            return json_encode($response_data);
        case ApiServices::BACKOFFICE:
            $response_content = $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_LOGIN);
            $response_data = json_decode($response_content, true);
            $response_data['sessionid'] = uniqid();

            return json_encode($response_data);
        case ApiServices::CUSTOMER:
            $response_content = $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::LOGIN);
            $response_data = json_decode($response_content, true);
            $response_data['sessionid'] = uniqid();

            return json_encode($response_data);
        }
    }

    // endregion

    // region MOCK CLIENT UTILITIES

    /**
     * Mocks a Guzzle http Client using an handler stack
     * built with an array of all the response that the client will return.
     *
     * @param array $responseBodiesQueue An array containing all the response bodies that the client should return
     *
     * @return ClientInterface
     */
    protected function mockClient(array $responseBodiesQueue): ClientInterface
    {
        // Prepare mock queue array from body content
        $mock_queue = array_map(
            function ($body) {
                return new Response(200, [], $body);
            },
            $responseBodiesQueue
        );

        // Mock the client
        $mock_handler = new MockHandler($mock_queue);
        $handler_stack = HandlerStack::create($mock_handler);

        return new Client(['handler' => $handler_stack]);
    }

    /**
     * This method (if mock_client_enabled is true) will add a mock http client ServiceFactory options
     * The second argument accepts an array of all the response bodies that the client will return.
     *
     * @param array $options             A valid set of Service Factory options
     * @param array $responseBodiesQueue An array containing all the response bodies that the client should return
     *
     * @return array
     */
    protected function addClientMockToFactoryOptions(array $options, array $responseBodiesQueue)
    {
        return $this->mock_client_enabled ? array_merge(
            $options,
            [FactoryOptions::HTTP_CLIENT => $this->mockClient($responseBodiesQueue)]
        ) : $options;
    }

    /**
     * This method is used to add in ServiceFactory options a specific mock http client to fake a single login response.
     *
     * @param array  $options     A valid set of Service Factory options
     * @param string $serviceType The service type to fake the login
     *
     * @return array
     */
    protected function addLoginClientMockToFactoryOptions(array $options, string $serviceType)
    {
        $response_queue = [
            $this->getFakeLoginResponse($serviceType),
        ];

        return $this->addClientMockToFactoryOptions($options, $response_queue);
    }

    // endregion

    // region DATA PROVIDERS

    /**
     * A "valid" factory options data provider.
     *
     * @return array[]
     */
    public function validFactoryOptionsDataProvider()
    {
        return [
            'customer service' => [
                ApiServices::CUSTOMER,
                CustomerService::class,
                $this->getCustomerServiceDemoFactoryOptions(),
            ],
            'backoffice service' => [
                ApiServices::BACKOFFICE,
                BackofficeService::class,
                $this->getBackofficeServiceDemoFactoryOptions(),
            ],
            'terminal service' => [
                ApiServices::TERMINAL,
                TerminalService::class,
                $this->getTerminalServiceDemoFactoryOptions(),
            ],
        ];
    }

    /**
     * Data provider to check session id key parameter.
     *
     * @return array[]
     */
    public function sessionIdKeyDataProvider()
    {
        return [
            'customer service' => [
                ApiServices::CUSTOMER,
                'session',
                $this->getCustomerServiceDemoFactoryOptions(),
            ],
            'backoffice service' => [
                ApiServices::BACKOFFICE,
                'sessionid',
                $this->getBackofficeServiceDemoFactoryOptions(),
            ],
            'terminal service' => [
                ApiServices::TERMINAL,
                'sessionid',
                $this->getTerminalServiceDemoFactoryOptions(),
            ],
        ];
    }

    /**
     * An "invalid" factory options data provider.
     *
     * @return array[]
     */
    public function invalidServiceFactoryOptionsDataProvider()
    {
        return [
            'unsupported service type' => [
                Messages::UNSUPPORTED_SERVICE_TYPE,
                FactoryOptions::SERVICE_TYPE => 'unsupported_service',
                [
                    //                    FactoryOptions::SERVICE_TYPE => 'unsupported_service',
                ],
            ],
            'missing terminal options for terminal service' => [
                Messages::MISSING_REQUIRED_SERVICE_OPTIONS,
                FactoryOptions::SERVICE_TYPE => ApiServices::TERMINAL,
                [
                    FactoryOptions::USERNAME => $this->terminal_demo_credentials[FactoryOptions::USERNAME],
                    FactoryOptions::PASSWORD => $this->terminal_demo_credentials[FactoryOptions::PASSWORD],
                ],
            ],
            'missing username options for terminal service' => [
                Messages::MISSING_REQUIRED_SERVICE_OPTIONS,
                FactoryOptions::SERVICE_TYPE => ApiServices::TERMINAL,
                [
                    FactoryOptions::PASSWORD => $this->terminal_demo_credentials[FactoryOptions::PASSWORD],
                    FactoryOptions::TERMINAL => $this->terminal_demo_credentials[FactoryOptions::TERMINAL],
                ],
            ],
            'missing password options for terminal service' => [
                Messages::MISSING_REQUIRED_SERVICE_OPTIONS,
                FactoryOptions::SERVICE_TYPE => ApiServices::TERMINAL,
                [
                    FactoryOptions::USERNAME => $this->terminal_demo_credentials[FactoryOptions::USERNAME],
                    FactoryOptions::TERMINAL => $this->terminal_demo_credentials[FactoryOptions::TERMINAL],
                ],
            ],
            'missing username options for backoffice service' => [
                Messages::MISSING_REQUIRED_SERVICE_OPTIONS,
                FactoryOptions::SERVICE_TYPE => ApiServices::BACKOFFICE,
                [
                    FactoryOptions::PASSWORD => $this->terminal_demo_credentials[FactoryOptions::PASSWORD],
                ],
            ],
            'missing password options for backoffice service' => [
                Messages::MISSING_REQUIRED_SERVICE_OPTIONS,
                FactoryOptions::SERVICE_TYPE => ApiServices::BACKOFFICE,
                [
                    FactoryOptions::USERNAME => $this->terminal_demo_credentials[FactoryOptions::USERNAME],
                ],
            ],
        ];
    }

    // endregion
}
