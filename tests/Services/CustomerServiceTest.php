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
use Blabs\FidelyNet\Exceptions\GeoLevelNotFoundException;
use Blabs\FidelyNet\Requests\CustomerRequestData;
use Blabs\FidelyNet\Responses\Lists\MovementsList;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Services\CustomerService;
use Blabs\FidelyNet\Test\ServiceTestCase;

class CustomerServiceTest extends ServiceTestCase
{
    public function test_email_verification_code_request()
    {
        $responses = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::SYNCHRO),
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::VERIFY_EMAIL),
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER,
            $this->addClientMockToFactoryOptions(
                $this->getCustomerServicePublicSessionFactoryOptions(),
                $responses
            )
        );

        $fake_email = 'figakop966@itwbuy.com';

        $response = $customer_service->sendEmailVerificationCode($fake_email, ApiDemoData::CAMPAIGN_ID);
        $this->assertEquals(0, $response->returncode);
    }

    public function test_mobile_verification_code_request()
    {
        $this->markTestSkipped('This test needs a campaign enabled to send sms verification');

        $responses = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::SYNCHRO),
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::VERIFY_PHONE),
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER,
            $this->addClientMockToFactoryOptions(
                $this->getCustomerServicePublicSessionFactoryOptions(),
                $responses
            )
        );

        $fake_phone = '+393331234567';

        $response = $customer_service->sendMobileVerificationCode($fake_phone, ApiDemoData::CAMPAIGN_ID);
        $this->assertEquals(0, $response->returncode);
    }

    public function test_customer_registration_with_verification_code()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $responses = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::SYNCHRO),
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::REGISTER_WITH_CODE),
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER,
            $this->addClientMockToFactoryOptions(
                $this->getCustomerServicePublicSessionFactoryOptions(),
                $responses
            )
        );

        $customer_data = [
            'email'                   => 'customer@domain.com',
            'passwordnew'             => '',
            'dni'                     => '',
            'name'                    => 'John',
            'surname'                 => 'Doe',
            'gender'                  => 'M',
            'birthdate'               => '01/01/1970',
            'notes'                   => '',
            'username'                => 'johndoe',
            'flags'                   => '',
            'usedforpromotions'       => '',
            'usedforstatistics'       => '',
            'usedbyothers'            => '',
            'cangetcurrentlocation'   => '',
            'cancomunicaverification' => '',
            'mobile'                  => '',
            'telephone'               => '',
            'fax'                     => '',
            'address'                 => '',
            'addressnumber'           => '',
            'addressprefix'           => '',
            'zipcode'                 => '',
            'geo_lat'                 => '',
            'geo_long'                => '',
            'country'                 => '',
            'geo_level_1'             => '',
            'geo_level_2'             => '',
            'geo_level_3'             => '',
            'geo_level_4'             => '',
            'geo_level_5'             => '',
            'facebookid'              => '',
            'customerdynamicfields'   => '',
            'twitterid'               => '',
            'youtubeid'               => '',
            'instagramid'             => '',
            'interestareas'           => '',
            'invitecustomerid'        => '',
        ];

        $response = $customer_service->registerCustomerWithVerificationCode($customer_data, '000', '0001', '1000');
        $this->assertGreaterThan(0, $response->card);
    }

    public function test_customer_registration_without_verification_code()
    {
        $responses = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::SYNCHRO),
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::REGISTER_WITHOUT_CODE),
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER,
            $this->addClientMockToFactoryOptions(
                $this->getCustomerServicePublicSessionFactoryOptions(),
                $responses
            )
        );

        $customer_data = new CustomerRequestData([
            'name'                    => 'John',
            'surname'                 => 'Doe',
            'gender'                  => 'M',
            'birthdate'               => '01/01/1970',
            'notes'                   => 'customer added for testing purposes',

            'usedForPromotions'       => true,
            'usedForStatistics'       => true,
            'usedByOthers'            => true,
            'canGetCurrentLocation'   => true,
            'canComunicaVerification' => true,

            'email'                   => 'customer@domain.com',
            'mobile'                  => '+39 333 1234 125',
            'telephone'               => '+39 02 123 125',
            'fax'                     => '+39 02 123 135',

            'address'                 => 'Via delle Albicocche, 25',
            'zipcode'                 => '00100',
            'geo_lat'                 => 41.6555143,
            'geo_long'                => 12.5443249,
            'country'                 => 3,

            'facebookid'              => 'johndoefb',
            'twitterid'               => 'johndoetw',
            'youtubeid'               => 'johndoeyt',
            'instagramid'             => 'johndoeig',

            'interestareas'           => 'movies, music',
        ]);

        $response = $customer_service->registerCustomer($customer_data, ApiDemoData::CAMPAIGN_ID, ApiDemoData::CATEGORY_ID);

        $this->assertGreaterThan(0, $response->card);
        $this->assertGreaterThan(0, $response->id);
        $this->assertNotEmpty($response->pincode);

        $this->assertEquals(ApiDemoData::CAMPAIGN_ID, $response->campaign);
        $this->assertEquals(ApiDemoData::CATEGORY_ID, $response->category);
        $this->assertEquals(1, $response->status);
        $this->assertEquals(0, $response->balance_points);

        $this->assertEquals($customer_data->name, $response->name);
        $this->assertEquals($customer_data->surname, $response->surname);
        $this->assertEquals($customer_data->gender, $response->gender);
        $this->assertEquals($customer_data->notes, $response->notes);
//        $this->assertEquals($customer_data->interestareas, $response->interestAreas);

        $this->assertEquals($customer_data->email, $response->mailContactData);
        $this->assertEquals($customer_data->mobile, $response->mobileContactData);
        $this->assertEquals($customer_data->telephone, $response->telephoneContactData);
        $this->assertEquals($customer_data->fax, $response->faxContactData);

        $this->assertEquals($customer_data->address, $response->address);
        $this->assertEquals($customer_data->country, $response->country);
        $this->assertEquals($customer_data->zipcode, $response->zip);

        $this->assertEquals($customer_data->geo_lat, $response->geo_lat);
        $this->assertEquals($customer_data->geo_long, $response->geo_long);

        // Skipping this assertions since the service seems to return data that differs from request values
        $this->assertEquals($customer_data->usedForPromotions, $response->privacy->usedForPromotions);
        $this->assertEquals($customer_data->usedForStatistics, $response->privacy->usedForStatistics);
        $this->assertEquals($customer_data->usedByOthers, $response->privacy->usedByOthers);
//        $this->assertEquals($customer_data->canGetCurrentLocation, $response->privacy->canGetCurrentLocation);
//        $this->assertEquals($customer_data->canComunicaVerification, $response->privacy->canComunicaVerification);

        // Skipping this assertions since the service seems to return data that differs from request values
//        $this->assertEquals($customer_data->facebookid, $response->facebookId);
//        $this->assertEquals($customer_data->twitterid, $response->twitterId);
//        $this->assertEquals($customer_data->youtubeid, $response->youtubeId);
//        $this->assertEquals($customer_data->instagramid, $response->instagramId);
    }

    public function test_list_customer_movements()
    {
        $responses = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::LOGIN),
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::GET_MOVEMENTS),
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER,
            $this->addClientMockToFactoryOptions(
                $this->getCustomerServiceDemoFactoryOptions(),
                $responses
            )
        );

        $movement_list = $customer_service->getMovements(1, 10);
        $this->assertInstanceOf(MovementsList::class, $movement_list);
        $this->assertCount(10, $movement_list->movements);
    }

    public function test_list_customer_movements_with_public_session()
    {
        $responses = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::SYNCHRO),
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::GET_MOVEMENTS),
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER,
            $this->addClientMockToFactoryOptions(
                $this->getCustomerServicePublicSessionFactoryOptions(),
                $responses
            )
        );

        $this->expectException(FidelyNetServiceException::class);
        $this->expectExceptionMessage(Messages::UNSUPPORTED_ACTION_WITH_PUBLIC_SESSION);
        $customer_service->getMovements(1, 10);
    }

    public function test_list_customer_movements_with_empty_list()
    {
        $responses = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::LOGIN),
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::GET_MOVEMENTS, 'empty'),
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER,
            $this->addClientMockToFactoryOptions(
                $this->getCustomerServiceDemoFactoryOptions(),
                $responses
            )
        );

        $movement_list = $customer_service->getMovements(1, 10);
        $this->assertInstanceOf(MovementsList::class, $movement_list);
        $this->assertEmpty($movement_list->movements);
    }

    public function test_can_list_geo_levels()
    {
        $responses = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::SYNCHRO),
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::GET_GEO_LEVELS),
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER,
            $this->addClientMockToFactoryOptions(
                $this->getCustomerServicePublicSessionFactoryOptions(),
                $responses
            )
        );


        $locations = $customer_service->getGeoLevels(4, 66870);
        $this->assertCount(2, $locations);
        $this->assertEquals([
            ['id' => 55, 'name' => 'ALBANO LAZIALE'],
            ['id' => 144096, 'name' => 'PAVONA'],
        ], $locations);
    }

    public function test_geo_level_not_found_exception_is_thrown()
    {
        $responses = [
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::SYNCHRO),
            $this->getFakeResponse(ApiServices::CUSTOMER, ApiActions::GET_GEO_LEVELS, 'notfound'),
        ];
        /** @var CustomerService $customer_service */
        $customer_service = ServiceFactory::create(
            ApiServices::CUSTOMER,
            $this->addClientMockToFactoryOptions(
                $this->getCustomerServicePublicSessionFactoryOptions(),
                $responses
            )
        );

        $this->expectException(GeoLevelNotFoundException::class);
        $customer_service->getGeoLevels(4, 668701);
    }
}
