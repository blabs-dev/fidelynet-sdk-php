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
        $this->mock_client_enabled = false;
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
}
