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

            'name'                    => 'Johnny',
            'surname'                 => 'Dorelli',
            'gender'                  => 'F',
            'birthdate'               => '1971-01-01',
            'notes'                   => 'customer UPDATED for testing purposes',
            'username'                => 'johnnydoe',

            'usedforpromotions'       => true,
            'usedforstatistics'       => false,
            'usedbyothers'            => true,
            'cangetcurrentlocation'   => false,
            'cancomunicaverification' => true,

            'mailcontactdata'         => 'updatedcustomer@domain.com',
            'mobilecontactdata'       => '+39 333 1234 125',
            'telephonecontactdata'    => '+39 02 123 125',
            'faxcontactdata'          => '+39 02 123 135',

            'address'                 => 'Via delle Colombe, 35',
            'zip'                     => '00101',
            'country'                 => 1,

            'facebookid'              => 'johnnydoe',
        ]);

        $response = $backoffice_service->modifyCustomer($customer_data);

        $this->assertEquals($customer_data->name, $response->personalInfo->name);
        $this->assertEquals($customer_data->surname, $response->personalInfo->surname);
        $this->assertEquals($customer_data->gender, $response->personalInfo->gender);
        $this->assertStringContainsString($customer_data->birthdate, $response->personalInfo->birthdate);
        $this->assertEquals($customer_data->notes, $response->personalInfo->notes);

        $this->assertEquals($customer_data->usedforpromotions, $response->personalInfo->privacy->usedForPromotions);
        $this->assertEquals($customer_data->usedforstatistics, $response->personalInfo->privacy->usedForStatistics);
        $this->assertEquals($customer_data->usedbyothers, $response->personalInfo->privacy->usedByOthers);
        $this->assertEquals($customer_data->cangetcurrentlocation, $response->personalInfo->privacy->canGetCurrentLocation);
        $this->assertEquals($customer_data->cancomunicaverification, $response->personalInfo->privacy->canComunicaVerification);

        $this->assertEquals($customer_data->mailcontactdata, $response->personalInfo->mailContactData);
        $this->assertEquals($customer_data->mobilecontactdata, $response->personalInfo->mobileContactData);
        $this->assertEquals($customer_data->telephonecontactdata, $response->personalInfo->telephoneContactData);
        $this->assertEquals($customer_data->faxcontactdata, $response->personalInfo->faxContactData);

        $this->assertEquals($customer_data->address, $response->personalInfo->address);
        $this->assertEquals($customer_data->zip, $response->personalInfo->zip);
        $this->assertEquals($customer_data->country, $response->personalInfo->country);

        $this->assertEquals($customer_data->facebookid, $response->personalInfo->facebookId);
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
