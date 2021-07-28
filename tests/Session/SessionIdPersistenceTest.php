<?php

namespace Blabs\FidelyNet\Test\Session;

use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Providers\SessionId\InMemorySessionIdProvider;
use Blabs\FidelyNet\Providers\SessionId\TmpDirSessionIdProvider;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Test\ServiceTestCase;

class SessionIdPersistenceTest extends ServiceTestCase
{
    public function test_tmp_file_can_be_wrote()
    {
        $provider = new TmpDirSessionIdProvider();
        $fake_session_id = 'fake-session-id';

        $this->assertFileExists($provider->getTmpFilePath());

        $provider->setSessionId($fake_session_id);

        $this->assertEquals($fake_session_id, $provider->getSessionId());
    }

    /**
     * @dataProvider validFactoryOptionsDataProvider
     *
     * @param string $serviceType
     * @param string $serviceClass
     * @param array $inputFactoryOptions
     * @throws FidelyNetServiceException
     */
    public function test_session_id_persists_across_two_different_service_instances_of_same_type(string $serviceType, string $serviceClass, array $inputFactoryOptions)
    {
        $responses_queue = [
            $this->getFakeLoginResponse($serviceType),
            $this->getFakeLoginResponse($serviceType),
        ];

        $factory_options = array_merge(
            $inputFactoryOptions,
            [FactoryOptions::SESSION_PERSISTS => true]
        );

        $factory_options = $this->addClientMockToFactoryOptions($factory_options, $responses_queue);

        $service_instance = ServiceFactory::create($serviceType, $factory_options);
        $session_id = $service_instance->getSessionId();
        $new_service_instance = ServiceFactory::create($serviceType, $factory_options);

        $this->assertInstanceOf($serviceClass, $service_instance);
        $this->assertInstanceOf($serviceClass, $new_service_instance);
        $this->assertTrue($new_service_instance->isSessionPersistent());
        $this->assertTrue($service_instance->isSessionPersistent());

        $this->assertEquals($session_id, $new_service_instance->getSessionId());
    }

    public function test_session_ids_from_different_service_types_are_different()
    {
        $backoffice_service = ServiceFactory::create(
            ApiServices::BACKOFFICE,
            $this->addLoginClientMockToFactoryOptions(
                $this->getBackofficeServiceDemoFactoryOptions(),
                ApiServices::BACKOFFICE
            )
        );
        $terminal_service = ServiceFactory::create(
            ApiServices::TERMINAL,
            $this->addLoginClientMockToFactoryOptions(
                $this->getTerminalServiceDemoFactoryOptions(),
                ApiServices::TERMINAL
            )
        );
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER,
            $this->addLoginClientMockToFactoryOptions(
                $this->getCustomerServiceDemoFactoryOptions(),
                ApiServices::CUSTOMER
            )
        );

        $this->assertNotEquals($backoffice_service->getSessionId(), $terminal_service->getSessionId());
        $this->assertNotEquals($backoffice_service->getSessionId(), $customer_service->getSessionId());
        $this->assertNotEquals($customer_service->getSessionId(), $terminal_service->getSessionId());
    }

    public function test_creating_service_with_in_memory_session_id_provider_gives_a_non_persistent_session_manager()
    {
        $factory_options = array_merge(
            [
                FactoryOptions::SESSION_ID_PROVIDER => new InMemorySessionIdProvider(),
            ],
            $this->getBackofficeServiceDemoFactoryOptions()
        );
        $factory_options = $this->addLoginClientMockToFactoryOptions($factory_options, ApiServices::BACKOFFICE);
        $backoffice_service = ServiceFactory::create(ApiServices::BACKOFFICE, $factory_options);
        $this->assertFalse($backoffice_service->isSessionPersistent());
    }
}
