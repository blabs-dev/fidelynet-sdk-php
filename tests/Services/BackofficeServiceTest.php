<?php

namespace Blabs\FidelyNet\Test\Services;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiDemoData;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Requests\CustomerRequestData;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Services\BackofficeService;
use Blabs\FidelyNet\Test\ServiceTestCase;

class BackofficeServiceTest extends ServiceTestCase
{
    public function test_customer_modify_action()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $responses = [
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_LOGIN),
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_MODIFY_CUSTOMER),
        ];
        /** @var BackofficeService $backoffice_service */
        $backoffice_service = ServiceFactory::create(
            ApiServices::BACKOFFICE,
            $this->addClientMockToFactoryOptions(
                $this->getBackofficeServiceDemoFactoryOptions(),
                $responses
            )
        );

        $customer_data = new CustomerRequestData([
            'email'                   => 'customer@domain.com',
            'dni'                     => '',
            'name'                    => 'John',
            'surname'                 => 'Doe',
            'gender'                  => 'M',
            'birthdate'               => '01/01/1970',
            'notes'                   => '',
            'username'                => 'johndoe',
            'flags'                   => '',
            'usedforpromotions'       => true,
            'usedforstatistics'       => true,
            'usedbyothers'            => true,
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
            'twitterid'               => '',
            'youtubeid'               => '',
            'instagramid'             => '',
            'interestareas'           => '',
            'invitecustomerid'        => '',
        ]);

        $response = $backoffice_service->modifyCustomer($customer_data, ApiDemoData::CUSTOMER_ID, ApiDemoData::CAMPAIGN_ID);
        $this->assertEquals($customer_data->name, $response->name);
    }

    public function test_get_card_info()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $responses = [
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_LOGIN),
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_GET_INFO_CARD),
        ];
        /** @var BackofficeService $backoffice_service */
        $backoffice_service = ServiceFactory::create(
            ApiServices::BACKOFFICE,
            $this->addClientMockToFactoryOptions(
                $this->getBackofficeServiceDemoFactoryOptions(),
                $responses
            )
        );

        $response = $backoffice_service->getCardInfo(ApiDemoData::CUSTOMER_CARD_NUMBER);

        $this->assertEquals(ApiDemoData::CUSTOMER_CARD_NUMBER, $response->card);
    }
}
