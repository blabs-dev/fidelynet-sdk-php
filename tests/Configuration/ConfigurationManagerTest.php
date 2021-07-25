<?php


namespace Blabs\FidelyNet\Test\Configuration;

use Blabs\FidelyNet\Configuration\ConfigurationManager;
use Blabs\FidelyNet\Configuration\DemoConfigurationProvider;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Test\ServiceTestCase;


class ConfigurationManagerTest extends ServiceTestCase
{
    public function test_using_configuration_manager_to_get_service_factory_options()
    {
        $configProvider = new DemoConfigurationProvider();
        $configManager = new ConfigurationManager($configProvider);
        $configOptions = $configManager->getOptions();

        $customerOptions = $this->addLoginClientMockToFactoryOptions($configOptions,ApiServices::CUSTOMER);

        $customerService = ServiceFactory::create(ApiServices::CUSTOMER,$customerOptions);
        $this->assertIsString($customerService->getSessionId());
    }
}