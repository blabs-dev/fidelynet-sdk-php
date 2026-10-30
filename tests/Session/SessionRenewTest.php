<?php

namespace Blabs\FidelyNet\Test\Session;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiDemoData;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Exceptions\FidelyNetSessionException;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Services\BackofficeService;
use Blabs\FidelyNet\Services\TerminalService;
use Blabs\FidelyNet\Session\SessionManager;
use Blabs\FidelyNet\Test\ServiceTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
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

    public function test_retry_after_renewal_sends_the_new_session_id()
    {
        $history = [];
        $service = $this->backofficeServiceWith($history, [
            new Response(200, [], json_encode(['returncode' => 0, 'sessionid' => 'first-session'])),
            new Response(200, [], $this->getFakeExpiredSessionResponse()),
            new Response(200, [], json_encode(['returncode' => 0, 'sessionid' => 'second-session'])),
            new Response(200, [], $this->getFakeMovementsResponse()),
        ]);

        $service->getAllMovements(new \DateTime('2026-09-01'), new \DateTime('2026-10-01'));

        $this->assertStringContainsString('first-session', (string) $history[1]['request']->getBody());
        $this->assertStringContainsString('second-session', (string) $history[3]['request']->getBody());
        $this->assertStringNotContainsString('first-session', (string) $history[3]['request']->getBody());
    }

    public function test_renew_limit_applies_to_consecutive_renewals_only()
    {
        $queue = [new Response(200, [], json_encode(['returncode' => 0, 'sessionid' => 'first-session']))];
        for ($i = 1; $i <= 5; $i++) {
            $queue[] = new Response(200, [], $this->getFakeExpiredSessionResponse());
            $queue[] = new Response(200, [], json_encode(['returncode' => 0, 'sessionid' => "session-$i"]));
            $queue[] = new Response(200, [], $this->getFakeMovementsResponse());
        }
        $history = [];
        $service = $this->backofficeServiceWith($history, $queue);

        for ($i = 1; $i <= 5; $i++) {
            $service->getAllMovements(new \DateTime('2026-09-01'), new \DateTime('2026-10-01'));
        }

        $this->assertEquals(5, $service->getSessionRenews());
    }

    private function backofficeServiceWith(array &$history, array $queue): BackofficeService
    {
        $stack = HandlerStack::create(new MockHandler($queue));
        $stack->push(Middleware::history($history));

        return ServiceFactory::create(ApiServices::BACKOFFICE, [
            FactoryOptions::HTTP_CLIENT      => new Client(['handler' => $stack]),
            FactoryOptions::DEMO_MODE        => true,
            FactoryOptions::SESSION_PERSISTS => false,
            FactoryOptions::USERNAME         => 'operator',
            FactoryOptions::PASSWORD         => 'secret',
        ]);
    }

    private function getFakeMovementsResponse(): string
    {
        return json_encode(['returncode' => 0, 'data' => [
            'movementTotal' => ['movementCount' => 0, 'customerCount' => 0, 'totalMoney' => 0, 'averageTicket' => 0, 'chargedPoints' => 0, 'dischargedPoints' => 0],
            'movements'     => [],
            'pagination'    => ['InitLimit' => 0, 'rowCount' => 100, 'orders' => null, 'recordsTotal' => 0, 'actualPage' => 1, 'totalPages' => 0],
        ]]);
    }
}
