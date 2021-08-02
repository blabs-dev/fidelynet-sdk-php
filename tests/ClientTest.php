<?php

namespace Blabs\FidelyNet\Test;

use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\ServiceFactory;

class ClientTest extends ServiceTestCase
{
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
}