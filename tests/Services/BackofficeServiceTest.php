<?php

namespace Blabs\FidelyNet\Test\Services;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiDemoData;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Exceptions\CustomerNotFoundException;
use Blabs\FidelyNet\Exceptions\UnauthorizedActionException;
use Blabs\FidelyNet\Requests\ModifyCustomerRequestData;
use Blabs\FidelyNet\Responses\DataModels\DynamicField;
use Blabs\FidelyNet\Responses\DataModels\MovementBackOfficeData;
use Blabs\FidelyNet\Responses\DataModels\ShopCategoryData;
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

    public function test_get_card_info_will_throw_an_exception_when_customer_does_not_exists()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $responses = [
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_LOGIN),
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_GET_INFO_CARD, 'customer-not-exists'),
        ];
        /** @var BackofficeService $backoffice_service */
        $backoffice_service = ServiceFactory::create(
            ApiServices::BACKOFFICE,
            $this->addClientMockToFactoryOptions(
                $this->getBackofficeServiceDemoFactoryOptions(),
                $responses
            )
        );

        $this->expectException(CustomerNotFoundException::class);
        $backoffice_service->getCardInfo(ApiDemoData::CUSTOMER_CARD_NUMBER);
    }

    public function test_modify_username_and_password()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $responses = [
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_LOGIN),
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_MODIFY_USERNAME_AND_PASSWORD),
        ];
        /** @var BackofficeService $backoffice_service */
        $backoffice_service = ServiceFactory::create(
            ApiServices::BACKOFFICE,
            $this->addClientMockToFactoryOptions(
                $this->getBackofficeServiceDemoFactoryOptions(),
                $responses
            )
        );

        $testCustomerId = 439403;
        $testUsername = 'testblabs';
        $testPassword = '123456';
        $result = $backoffice_service->modifyUsernameAndPassword($testCustomerId, $testUsername, $testPassword);
        $this->assertEquals($testCustomerId, $result->id);
    }

    public function test_get_dynamic_fields()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $responses = [
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_LOGIN),
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_GET_DYNAMIC_FIELDS),
        ];
        /** @var BackofficeService $backoffice_service */
        $backoffice_service = ServiceFactory::create(
            ApiServices::BACKOFFICE,
            $this->addClientMockToFactoryOptions(
                $this->getBackofficeServiceDemoFactoryOptions(),
                $responses
            )
        );

        $dynamic_fields = $backoffice_service->getDynamicFields();
        $this->assertCount(3, $dynamic_fields);

        $single_field = $dynamic_fields[0];
        $this->assertInstanceOf(DynamicField::class, $single_field);
        $this->assertEquals(1328, $single_field->id);
        $this->assertEquals('city', $single_field->name);
    }

    public function test_get_movement_list()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $responses = [
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_LOGIN),
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_GET_MOVEMENT_LIST),
        ];
        /** @var BackofficeService $backoffice_service */
        $backoffice_service = ServiceFactory::create(
            ApiServices::BACKOFFICE,
            $this->addClientMockToFactoryOptions(
                $this->getBackofficeServiceDemoFactoryOptions(),
                $responses
            )
        );

        $response = $backoffice_service->getMovementList(ApiDemoData::CUSTOMER_CARD_NUMBER, new \DateTime(), new \DateTime());

        $this->assertIsArray($response->movements);
        $first_item = $response->movements[0];
        $this->assertCount(9, $response->movements);
        $this->assertInstanceOf(MovementBackOfficeData::class, $first_item);
    }

    public function test_get_top_level_categories()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $responses = [
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_LOGIN),
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_GET_SHOP_CATEGORIES, 'top-level'),
        ];
        /** @var BackofficeService $backoffice_service */
        $backoffice_service = ServiceFactory::create(
            ApiServices::BACKOFFICE,
            $this->addClientMockToFactoryOptions(
                $this->getBackofficeServiceDemoFactoryOptions(),
                $responses
            )
        );

        $topLevelCategories = $backoffice_service->getShopCategories();
        $this->assertCount(20, $topLevelCategories);
        $this->assertInstanceOf(ShopCategoryData::class, $topLevelCategories[0]);
    }

    public function test_get_child_categories()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $responses = [
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_LOGIN),
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_GET_SHOP_CATEGORIES, '1292'),
        ];
        /** @var BackofficeService $backoffice_service */
        $backoffice_service = ServiceFactory::create(
            ApiServices::BACKOFFICE,
            $this->addClientMockToFactoryOptions(
                $this->getBackofficeServiceDemoFactoryOptions(),
                $responses
            )
        );

        $childCategories = $backoffice_service->getShopCategories(1292);
        $this->assertCount(23, $childCategories);
        $firstChild = $childCategories[0];
        $this->assertInstanceOf(ShopCategoryData::class, $firstChild);
        $this->assertEquals(1292, $firstChild->fatherId);
    }

    public function test_get_shops_and_networks()/**/
    {
        $this->markTestSkipped('to do');
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $responses = [
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_LOGIN),
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_GET_SHOPS),
        ];
        /** @var BackofficeService $backoffice_service */
        $backoffice_service = ServiceFactory::create(
            ApiServices::BACKOFFICE,
            $this->addClientMockToFactoryOptions(
                $this->getBackofficeServiceDemoFactoryOptions(),
                $responses
            )
        );
    }

    public function test_modify_pin_code_action_will_throw_unauthorized_action_exception_for_unauthorized_operator()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $responses = [
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_LOGIN),
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_MODIFY_PIN_CODE, 'unauthorized'),
        ];
        /** @var BackofficeService $backoffice_service */
        $backoffice_service = ServiceFactory::create(
            ApiServices::BACKOFFICE,
            $this->addClientMockToFactoryOptions(
                $this->getBackofficeServiceDemoFactoryOptions(),
                $responses
            )
        );

        $this->expectException(UnauthorizedActionException::class);
        $backoffice_service->modifyPinCode('1', 1, '1234');
    }

    public function test_modify_pin_code_action_()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $responses = [
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_LOGIN),
            $this->getFakeResponse(ApiServices::BACKOFFICE, ApiActions::BO_MODIFY_PIN_CODE),
        ];
        /** @var BackofficeService $backoffice_service */
        $backoffice_service = ServiceFactory::create(
            ApiServices::BACKOFFICE,
            $this->addClientMockToFactoryOptions(
                $this->getBackofficeServiceDemoFactoryOptions(),
                $responses
            )
        );

        $customer_data = $backoffice_service->modifyPinCode('3', 15841, '1234');
        $this->assertEquals(15841, $customer_data->id);
    }
}
