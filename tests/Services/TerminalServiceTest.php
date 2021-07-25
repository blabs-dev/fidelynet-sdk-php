<?php


namespace Blabs\FidelyNet\Test\Services;


use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiDemoData;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Services\TerminalService;
use Blabs\FidelyNet\Test\ServiceTestCase;

class TerminalServiceTest extends ServiceTestCase
{
    public function test_unsupported_action_call_throw_an_exception()
    {
        $factory_options = $this->addLoginClientMockToFactoryOptions(
            $this->getTerminalServiceDemoFactoryOptions(), ApiServices::TERMINAL
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
            $this->getFakeResponse(ApiServices::TERMINAL, ApiActions::GET_CAMPAIGN)
        ];

        $demo_options = $this->getTerminalServiceDemoFactoryOptions();
        $factory_options = $this->addClientMockToFactoryOptions($demo_options, $response_bodies_queue);

        /** @var TerminalService $service */
        $service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);
        $campaign_info = $service->getCampaign(ApiDemoData::CAMPAIGN_ID);
        $this->assertEquals(ApiDemoData::CAMPAIGN_ID, $campaign_info->campaign->id);
    }
}
