<?php

namespace Blabs\FidelyNet\Test\Session;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiDemoData;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Exceptions\FidelyNetSessionException;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Services\TerminalService;
use Blabs\FidelyNet\Session\SessionManager;
use Blabs\FidelyNet\Test\ServiceTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class SessionRenewTest extends ServiceTestCase
{
    public function test_session_is_renewed_automatically()
    {
        $mock = new MockHandler(
            [
                // Prima response di login per la creazione del servizio
                new Response(200, [], $this->getFakeLoginResponse(ApiServices::TERMINAL)),
                // Response di sessione scaduta
                new Response(200, [], $this->getFakeExpiredSessionResponse()),
                // Response di login per rinnovo sessione
                new Response(200, [], $this->getFakeLoginResponse(ApiServices::TERMINAL)),
                // Response corretta
                new Response(200, [], $this->getFakeResponse(ApiServices::TERMINAL, ApiActions::TERM_GET_CAMPAIGN)),
            ]
        );
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $factory_options = array_merge(
            [FactoryOptions::HTTP_CLIENT => $client],
            $this->getTerminalServiceDemoFactoryOptions()
        );
        /** @var TerminalService $terminal_service */
        $terminal_service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);

        $campaign_data = $terminal_service->getCampaign(ApiDemoData::CAMPAIGN_ID);
        $this->assertEquals(1, $terminal_service->getSessionRenews());
        $this->assertEquals(ApiDemoData::CAMPAIGN_ID, $campaign_data->campaign->id);
    }

    public function test_session_cant_be_renewed_after_max_tries()
    {
        $response_queue = [];

        for ($i = 1; $i <= SessionManager::MAX_SESSION_RENEW_TRIES; $i++) {
            $response_queue[] = new Response(200, [], $this->getFakeLoginResponse(ApiServices::TERMINAL));
            $response_queue[] = new Response(200, [], $this->getFakeExpiredSessionResponse());
        }

        $mock = new MockHandler($response_queue);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $factory_options = array_merge(
            [FactoryOptions::HTTP_CLIENT => $client],
            $this->getTerminalServiceDemoFactoryOptions()
        );
        /** @var TerminalService $terminal_service */
        $terminal_service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);
        $this->expectException(FidelyNetSessionException::class);
        $this->expectExceptionMessage(Messages::MAX_SESSION_RENEWS);
        $terminal_service->getCampaign(ApiDemoData::CAMPAIGN_ID);
    }
}
