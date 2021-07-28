<?php

namespace Blabs\FidelyNet\Test\Factory;

use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Test\ServiceTestCase;

class ServiceFactoryTest extends ServiceTestCase
{
    /**
     * @dataProvider validFactoryOptionsDataProvider
     *
     * @param string $serviceType
     * @param string $expectedClass
     * @param array  $inputOptions
     *
     * @throws FidelyNetServiceException
     */
    public function test_service_is_created_with_valid_demo_options(string $serviceType, string $expectedClass, array $inputOptions)
    {
        // Adds a mock http client to factory options
        $factory_options = $this->addLoginClientMockToFactoryOptions($inputOptions, $serviceType);

        // Creates the service and performs assertions
        $service = ServiceFactory::create($serviceType, $factory_options);
        $this->assertInstanceOf($expectedClass, $service);
        $this->assertTrue($service->isDemoMode());
        $this->assertEquals(1, $service->getRequestCount());
        $this->assertNotEmpty($service->getSessionId());
    }

    public function test_service_is_created_without_starting_session()
    {
        // Adds a mock http client to factory options
        $factory_options = $this->addLoginClientMockToFactoryOptions($this->getCustomerServiceDemoFactoryOptions(), ApiServices::CUSTOMER);
        $factory_options = array_merge($factory_options, [FactoryOptions::START_SESSION => false]);

        // Creates the service and performs assertions
        $service = ServiceFactory::create(ApiServices::CUSTOMER, $factory_options);
        $this->assertEmpty($service->getSessionId());
        $this->assertEquals(0, $service->getRequestCount());

        // Starts session
        $service->initSession();
        $this->assertNotEmpty($service->getSessionId());
        $this->assertEquals(1, $service->getRequestCount());
    }

    /**
     * @dataProvider invalidServiceFactoryOptionsDataProvider
     *
     * @param string $expectedMessage
     * @param string $serviceType
     * @param array  $inputOptions
     *
     * @throws FidelyNetServiceException
     */
    public function test_exception_is_thrown_when_required_service_options_is_missing(string $expectedMessage, string $serviceType, array $inputOptions)
    {
        $this->expectExceptionMessage($expectedMessage);
        ServiceFactory::create($serviceType, $inputOptions);
    }

    /**
     * @dataProvider sessionIdKeyDataProvider
     *
     * @param string $serviceType
     * @param string $expectedKey
     * @param array  $inputOptions
     *
     * @throws FidelyNetServiceException
     */
    public function test_session_id_key_is_set_accordingly(string $serviceType, string $expectedKey, array $inputOptions)
    {
        // Adds a mock http client to factory options
        $factory_options = $this->addLoginClientMockToFactoryOptions($inputOptions, $serviceType);

        // Creates the service and performs assertions
        $service = ServiceFactory::create($serviceType, $factory_options);
        $this->assertArrayHasKey($expectedKey, $service->getDefaultParameters());
    }

    public function test_demo_mode_is_not_enabled_if_not_specified()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be executed only with a mock client');
        }
        //        $mock_client_enabled_current_state = $this->mock_client_enabled;
        //        $this->mock_client_enabled = true;
        // Build Factory Options
        $demo_options = $this->getTerminalServiceDemoFactoryOptions();
        unset($demo_options[FactoryOptions::DEMO_MODE]);
        $factory_options = $this->addLoginClientMockToFactoryOptions($demo_options, ApiServices::TERMINAL);

        $service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);
        $this->assertFalse($service->isDemoMode());
        //        $this->mock_client_enabled = $mock_client_enabled_current_state;
    }
}
