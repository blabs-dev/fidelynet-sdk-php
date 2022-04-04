<?php

namespace Blabs\FidelyNet\Test;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Services\ServiceAbstract;

class ClientTest extends ServiceTestCase
{
    protected ServiceAbstract $testBackofficeService;

    public function test_unknown_response_exception_is_thrown()
    {
        $this->expectException(FidelyNetServiceException::class);
        $this->expectExceptionMessage(Messages::UNKNOWN_ERROR);

        $this->mockClient([]);
        ServiceFactory::create(
            ApiServices::CUSTOMER,
            $this->addClientMockToFactoryOptions(
                $this->getCustomerServicePublicSessionFactoryOptions(),
                ['unknown response']
            )
        );
    }

    public function test_unknown_response_body_is_reported_in_service_exception()
    {
        try {
            ServiceFactory::create(
                ApiServices::CUSTOMER,
                $this->addClientMockToFactoryOptions(
                    $this->getCustomerServicePublicSessionFactoryOptions(),
                    ['unknown response']
                )
            );
        } catch (FidelyNetServiceException $exception) {
            $this->assertEquals('unknown response', $exception->getResponseBody());
        }
    }

    /**
     * @test
     */
    public function it_will_include_correct_environment_parameter_in_demo_mode()
    {
        $this->setUpBackofficeService(true);

        $default_parameters = $this->testBackofficeService->getDefaultParameters();

        $this->assertArrayHasKey('ambiente', $default_parameters);
        $this->assertEquals('DEMO', $default_parameters['ambiente']);
    }

    /**
     * @test
     */
    public function it_will_include_correct_environment_parameter_in_production_mode()
    {
        $this->setUpBackofficeService(false);

        $default_parameters = $this->testBackofficeService->getDefaultParameters();

        $this->assertArrayHasKey('ambiente', $default_parameters);
        $this->assertEquals('PROD', $default_parameters['ambiente']);
    }

    /**
     * @throws FidelyNetServiceException
     */
    private function setUpBackofficeService($demoModeEnabled = true)
    {
        $responses = [
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_LOGIN),
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_MODIFY_CUSTOMER),
        ];

        $service_options = $this->getBackofficeServiceDemoFactoryOptions();

        $service_options[FactoryOptions::DEMO_MODE] = $demoModeEnabled;

        $this->testBackofficeService = ServiceFactory::create(
            ApiServices::BACKOFFICE,
            $this->addClientMockToFactoryOptions(
                $service_options,
                $responses
            )
        );
    }
}
