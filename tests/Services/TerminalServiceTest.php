<?php

namespace Blabs\FidelyNet\Test\Services;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiDemoData;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Responses\DataModels\CategoryData;
use Blabs\FidelyNet\Responses\ResponseData\CardInfoResponseData;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Services\TerminalService;
use Blabs\FidelyNet\Test\ServiceTestCase;

class TerminalServiceTest extends ServiceTestCase
{
    public function test_unsupported_action_call_throw_an_exception()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $factory_options = $this->addLoginClientMockToFactoryOptions(
            $this->getTerminalServiceDemoFactoryOptions(),
            ApiServices::TERMINAL
        );

        $service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);
        $this->expectException(FidelyNetServiceException::class);
        $this->expectExceptionMessage(Messages::UNSUPPORTED_ACTION);
        $service->callAction('UNSUPPORTED', []);
    }

    public function test_get_campaign_action()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $response_bodies_queue = [
            $this->getFakeLoginResponse(ApiServices::TERMINAL),
            $this->getFakeResponse(ApiServices::TERMINAL, ApiActions::TERM_GET_CAMPAIGN),
        ];

        $demo_options = $this->getTerminalServiceDemoFactoryOptions();
        $factory_options = $this->addClientMockToFactoryOptions($demo_options, $response_bodies_queue);

        /** @var TerminalService $service */
        $service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);
        $campaign_info = $service->getCampaign(ApiDemoData::CAMPAIGN_ID);
        $this->assertEquals(ApiDemoData::CAMPAIGN_ID, $campaign_info->campaign->id);
    }

    public function test_check_card_action()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $response_bodies_queue = [
            $this->getFakeResponse(ApiServices::TERMINAL, ApiActions::TERM_CHECK_CARD),
        ];
        $demo_options = $this->getTerminalServiceDemoFactoryOptions();
        $factory_options = $this->addClientMockToFactoryOptions($demo_options, $response_bodies_queue);
        $factory_options[FactoryOptions::START_SESSION] = false;
        /** @var TerminalService $service */
        $service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);

        $check_card = $service->checkCard(
            ApiDemoData::CAMPAIGN_ID,
            ApiDemoData::CUSTOMER_CARD_CODE,
            ApiDemoData::TERMINAL_USERNAME,
            ApiDemoData::TERMINAL_PASSWORD,
        );

        $this->assertEquals(CardInfoResponseData::class, get_class($check_card));
        $this->assertEquals(437948, $check_card->id);
        $this->assertEquals(53424185296134, $check_card->fidelyCode);
        $this->assertEquals('1', $check_card->card);
    }

    public function test_get_categories_action()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $response_bodies_queue = [
            $this->getFakeLoginResponse(ApiServices::TERMINAL),
            $this->getFakeResponse(ApiServices::TERMINAL, ApiActions::TERM_GET_CATEGORIES),
        ];
        $demo_options = $this->getTerminalServiceDemoFactoryOptions();
        $factory_options = $this->addClientMockToFactoryOptions($demo_options, $response_bodies_queue);
        /** @var TerminalService $service */
        $service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);

        $categories = $service->getCategories();

        $this->assertCount(2, $categories);
        foreach ($categories as $category) {
            $this->assertEquals(CategoryData::class, get_class($category));
        }
    }

    public function test_get_logged_shop_info()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $response_bodies_queue = [
            $this->getFakeLoginResponse(ApiServices::TERMINAL),
            $this->getFakeResponse(ApiServices::TERMINAL, ApiActions::TERM_GET_LOGGED_SHOP_INFO),
        ];
        $demo_options = $this->getTerminalServiceDemoFactoryOptions();
        $factory_options = $this->addClientMockToFactoryOptions($demo_options, $response_bodies_queue);
        /** @var TerminalService $service */
        $service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);

        $shop = $service->getLoggedShopInfo();

        $this->assertEquals(61543, $shop->id);
        $this->assertEquals("Aci", $shop->name);
    }

    public function test_get_card_info()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $response_bodies_queue = [
            $this->getFakeLoginResponse(ApiServices::TERMINAL),
            $this->getFakeResponse(ApiServices::TERMINAL, ApiActions::TERM_GET_CARD_INFO),
        ];
        $demo_options = $this->getTerminalServiceDemoFactoryOptions();
        $factory_options = $this->addClientMockToFactoryOptions($demo_options, $response_bodies_queue);
        /** @var TerminalService $service */
        $service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);

        $card = $service->getCardInfo("3000170");

        $this->assertEquals("3000170", $card->card);
        $this->assertEquals(53424585278354, $card->fidelyCode);
        $this->assertEquals(463943, $card->id);
        $this->assertEquals(1302, $card->campaignId);

    }
    public function test_charge_points()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $response_bodies_queue = [
            $this->getFakeLoginResponse(ApiServices::TERMINAL),
            $this->getFakeResponse(ApiServices::TERMINAL, ApiActions::TERM_CHARGE_POINTS),
        ];
        $demo_options = $this->getTerminalServiceDemoFactoryOptions();
        $factory_options = $this->addClientMockToFactoryOptions($demo_options, $response_bodies_queue);
        /** @var TerminalService $service */
        $service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);

        $movementData = $service->chargePoints(
            cardNumber: "3000170",
            campaignId: 1302,
            customerId: 463943,
            mooneyAmount: 100,
            cashbackAmount: 10
        );

        $this->assertEquals(1996782, $movementData->id);
        $this->assertEquals(6857, $movementData->terminal);
        $this->assertEquals(6218, $movementData->shopId);
        $this->assertEquals("3000170", $movementData->card);
        $this->assertEquals(463943, $movementData->customer);
        $this->assertEquals(10, $movementData->chargedPoints);
        $this->assertEquals(100, $movementData->totalMoney);
        $this->assertEquals(1, $movementData->kindCharge);

    }

    public function test_discharge_points()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $response_bodies_queue = [
            $this->getFakeLoginResponse(ApiServices::TERMINAL),
            $this->getFakeResponse(ApiServices::TERMINAL, ApiActions::TERM_DISCHARGE_POINTS),
        ];
        $demo_options = $this->getTerminalServiceDemoFactoryOptions();
        $factory_options = $this->addClientMockToFactoryOptions($demo_options, $response_bodies_queue);
        /** @var TerminalService $service */
        $service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);

        $movementData = $service->disChargePoints(
            cardNumber: "3000170",
            campaignId: 1302,
            customerId: 463943,
            cashbackAmount: 10,
            mooneyAmount: 10
        );

        $this->assertEquals(1996791, $movementData->id);
        $this->assertEquals(6857, $movementData->terminal);
        $this->assertEquals(6218, $movementData->shopId);
        $this->assertEquals("3000170", $movementData->card);
        $this->assertEquals(463943, $movementData->customer);
        $this->assertEquals(0, $movementData->chargedPoints);
        $this->assertEquals(5, $movementData->dischargedPoints);
        $this->assertEquals(10, $movementData->totalMoney);
        $this->assertEquals(0, $movementData->kindCharge);

    }

    public function test_sale_product()
    {
        if (!$this->mock_client_enabled) {
            $this->markTestSkipped('This test can be performed only with a mock client');
        }

        $response_bodies_queue = [
            $this->getFakeLoginResponse(ApiServices::TERMINAL),
            $this->getFakeResponse(ApiServices::TERMINAL, ApiActions::TERM_SALE_PRODUCT ),
        ];
        $demo_options = $this->getTerminalServiceDemoFactoryOptions();
        $factory_options = $this->addClientMockToFactoryOptions($demo_options, $response_bodies_queue);
        /** @var TerminalService $service */
        $service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);

        $movementData = $service->saleMovement(
            cardNumber: "3000170",
            campaignId: 1302,
            customerId: 463943,
            mooneyAmount: 500,
        );

        $this->assertEquals(1996787, $movementData->id);
        $this->assertEquals(6857, $movementData->terminal);
        $this->assertEquals(6218, $movementData->shopId);
        $this->assertEquals("3000170", $movementData->card);
        $this->assertEquals(463943, $movementData->customer);
        $this->assertEquals(5, $movementData->chargedPoints);
        $this->assertEquals(500, $movementData->totalMoney);
        $this->assertEquals(0, $movementData->kindCharge);

    }
}
