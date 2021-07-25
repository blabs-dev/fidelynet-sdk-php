<?php
/*
 * Copyright (c) B@Labs srl 2021.
 * @category Tests
 * @package  Blabs/FidelyNet
 * @author   Salvo Bonanno <s.bonanno@blabs.it>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://www.blabs.it
 *
 */

namespace Blabs\FidelyNet\Test\Services;


use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiDemoData;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Responses\Lists\MovementsList;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Services\CustomerService;
use Blabs\FidelyNet\Test\ServiceTestCase;

class CustomerServiceTest extends ServiceTestCase
{
    public function test_email_verification_code_request() {
        $responses = [
           $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::SYNCHRO),
           $this->getFakeResponse(ApiServices::CUSTOMER,ApiActions::VERIFY_EMAIL)
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER, $this->addClientMockToFactoryOptions(
            $this->getCustomerServicePublicSessionFactoryOptions(),
            $responses
        )
        );

        $fake_email = 'figakop966@itwbuy.com';

        $response = $customer_service->sendEmailVerificationCode($fake_email, ApiDemoData::CAMPAIGN_ID);
        $this->assertEquals(0,$response->returncode);
    }

    public function test_mobile_verification_code_request() {
        $this->markTestSkipped('This test needs a campaign enabled to send sms verification');

        $responses = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::SYNCHRO),
            $this->getFakeResponse(ApiServices::CUSTOMER,ApiActions::VERIFY_EMAIL)
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER, $this->addClientMockToFactoryOptions(
            $this->getCustomerServicePublicSessionFactoryOptions(),
            $responses
        )
        );

        $fake_phone = '+393331234567';

        $response = $customer_service->sendMobileVerificationCode($fake_phone, ApiDemoData::CAMPAIGN_ID);
        $this->assertEquals(0,$response->returncode);
    }

    public function test_customer_registration_with_verification_code() {
        if (!$this->mock_client_enabled)
            $this->markTestSkipped('This test can be performed only with a mock client');

        $responses = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::SYNCHRO),
            $this->getFakeResponse(ApiServices::CUSTOMER,ApiActions::REGISTER_WITH_VC)
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER, $this->addClientMockToFactoryOptions(
            $this->getCustomerServicePublicSessionFactoryOptions(),
            $responses
        )
        );

        $customer_data = [
            'email' => 'customer@domain.com',
            'passwordnew' => '',
            'dni' => '',
            'name' => 'John',
            'surname' => 'Doe',
            'gender' => 'M',
            'birthdate' => '01/01/1970',
            'notes' => '',
            'username' => 'johndoe',
            'flags' => '',
            'usedforpromotions' => '',
            'usedforstatistics' => '',
            'usedbyothers' => '',
            'cangetcurrentlocation' => '',
            'cancomunicaverification' => '',
            'mobile' => '',
            'telephone' => '',
            'fax' => '',
            'address' => '',
            'addressnumber' => '',
            'addressprefix' => '',
            'zipcode' => '',
            'geo_lat' => '',
            'geo_long' => '',
            'country' => '',
            'geo_level_1' => '',
            'geo_level_2' => '',
            'geo_level_3' => '',
            'geo_level_4' => '',
            'geo_level_5' => '',
            'facebookid' => '',
            'customerdynamicfields' => '',
            'twitterid' => '',
            'youtubeid' => '',
            'instagramid' => '',
            'interestareas' => '',
            'invitecustomerid' => '',
        ];

        $response = $customer_service->registerCustomerWithVerificationCode($customer_data, '000','0001', '1000');
        $this->assertGreaterThan(0,$response->card);
    }

    public function test_list_customer_movements() {
        $responses = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::LOGIN),
            $this->getFakeResponse(ApiServices::CUSTOMER,ApiActions::GET_MOVEMENTS)
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER, $this->addClientMockToFactoryOptions(
            $this->getCustomerServiceDemoFactoryOptions(),
            $responses
        )
        );

        $movement_list = $customer_service->getMovements(1, 10);
        $this->assertInstanceOf(MovementsList::class,$movement_list);
        $this->assertCount(10,$movement_list->movements);
    }

    public function test_list_customer_movements_with_public_session() {
        $responses = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::SYNCHRO),
            $this->getFakeResponse(ApiServices::CUSTOMER,ApiActions::GET_MOVEMENTS)
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER, $this->addClientMockToFactoryOptions(
            $this->getCustomerServicePublicSessionFactoryOptions(),
            $responses
        )
        );

        $this->expectException(FidelyNetServiceException::class);
        $this->expectExceptionMessage(Messages::UNSUPPORTED_ACTION_WITH_PUBLIC_SESSION);
        $customer_service->getMovements(1, 10);
    }

    public function test_list_customer_movements_with_empty_list() {
        $responses = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::LOGIN),
            $this->getFakeResponse(ApiServices::CUSTOMER,ApiActions::GET_MOVEMENTS,'empty')
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER, $this->addClientMockToFactoryOptions(
            $this->getCustomerServiceDemoFactoryOptions(),
            $responses
        )
        );

        $movement_list = $customer_service->getMovements(1, 10);
        $this->assertInstanceOf(MovementsList::class,$movement_list);
        $this->assertEmpty($movement_list->movements);
    }
}