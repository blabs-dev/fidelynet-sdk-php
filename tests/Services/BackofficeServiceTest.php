<?php

namespace Blabs\FidelyNet\Test\Services;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiDemoData;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Requests\ModifyCustomerRequestData;
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

        $customer_data = new ModifyCustomerRequestData([
            'id'                      => ApiDemoData::CUSTOMER_ID,
            'campaignid'              => ApiDemoData::CAMPAIGN_ID,

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

            'mailcontactdata'         => 'customer@domain.com',
            'mobilecontactdata'       => '123123123',
            'telephonecontactdata'    => '',
            'faxcontactdata'          => '',

            'address'                 => '',
            'addressnumber'           => '',
            'addressprefix'           => '',
            'zip'                     => '',
            //            'country'                 => '',

            'facebookid'              => '',
        ]);

        $response = $backoffice_service->modifyCustomer($customer_data);

        $this->assertEquals($customer_data->name, $response->personalInfo->name);
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
