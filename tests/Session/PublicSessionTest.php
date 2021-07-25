<?php

namespace Blabs\FidelyNet\Test\Session;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\ApiSessionTypes;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Test\ServiceTestCase;

class PublicSessionTest extends ServiceTestCase
{
    public function test_public_session_cant_be_started_on_other_services()
    {
        $factory_options = array_merge(
            $this->getTerminalServiceDemoFactoryOptions(),
            [FactoryOptions::SESSION_TYPE => ApiSessionTypes::PUBLIC]
        );
        $this->expectException(FidelyNetServiceException::class);
        $this->expectExceptionMessage(Messages::UNSUPPORTED_ACTION);
        ServiceFactory::create(ApiServices::TERMINAL, $factory_options);
    }

    public function test_public_session_can_be_started_on_customer_service()
    {
        $response_bodies_queue = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::SYNCHRO),
        ];
        $demo_options = $this->getCustomerServicePublicSessionFactoryOptions();
        $factory_options = $this->addClientMockToFactoryOptions($demo_options, $response_bodies_queue);

        $factory_options = array_merge(
            $factory_options,
            [FactoryOptions::SESSION_TYPE => ApiSessionTypes::PUBLIC]
        );
        $service = ServiceFactory::create(ApiServices::CUSTOMER, $factory_options);
        $this->assertEquals(ApiSessionTypes::PUBLIC, $service->getSessionType());
        $this->assertNotEmpty($service->getSessionId());
    }
}
