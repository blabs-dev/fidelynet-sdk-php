<?php


namespace Blabs\FidelyNet\Test\Services;


use Blabs\FidelyNet\Constants\ApiDemoData;
use Blabs\FidelyNet\Constants\ApiMessages;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Exceptions\BadRequestException;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Services\TerminalService;
use Blabs\FidelyNet\Test\ServiceTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class ServiceErrorsTest extends ServiceTestCase
{
    public function test_http_client_exception_is_thrown()
    {
        $mock = new MockHandler(
            [
            new Response(200, [], $this->getFakeLoginResponse(ApiServices::TERMINAL)),
            new Response(422, [], ''),
            ]
        );
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $factory_options = array_merge(
            [ FactoryOptions::HTTP_CLIENT => $client ],
            $this->getTerminalServiceDemoFactoryOptions()
        );
        /** @var TerminalService $terminal_service  */
        $terminal_service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage(Messages::SERVICE_BAD_REQUEST);
        $terminal_service->getCampaign(ApiDemoData::CAMPAIGN_ID);
    }

    public function test_connection_exception_is_thrown()
    {
        $mock = new MockHandler(
            [
            new ConnectException('Network unreachable', new Request('POST', ApiServices::ENTRYPOINTS[ApiServices::TERMINAL])),
            ]
        );
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $factory_options = array_merge(
            [ FactoryOptions::HTTP_CLIENT => $client ],
            $this->getTerminalServiceDemoFactoryOptions()
        );
        $this->expectException(FidelyNetServiceException::class);
        $this->expectExceptionMessage(Messages::SERVICE_UNREACHABLE);
        ServiceFactory::create(ApiServices::TERMINAL, $factory_options);
    }

    public function test_api_bad_format_exception_is_thrown()
    {
        $mock = new MockHandler(
            [
            new Response(200, [], $this->getFakeLoginResponse(ApiServices::TERMINAL)),
            new Response(200, [], $this->getFakeBadRequestResponse()),
            ]
        );
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $factory_options = array_merge(
            [ FactoryOptions::HTTP_CLIENT => $client ],
            $this->getTerminalServiceDemoFactoryOptions()
        );
        /** @var TerminalService $terminal_service */
        $terminal_service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);
        $this->expectException(FidelyNetServiceException::class);
        $this->expectExceptionMessage(Messages::SERVICE_BAD_REQUEST);
        $terminal_service->getCampaign(ApiDemoData::CAMPAIGN_ID);
    }

    public function test_api_error_exception_is_thrown()
    {
        $random_error = array_rand(ApiMessages::CODES);
        $mock = new MockHandler(
            [
            new Response(200, [], $this->getFakeLoginResponse(ApiServices::TERMINAL)),
            new Response(200, [], $this->getFakeErrorResponse($random_error)),
            ]
        );
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $factory_options = array_merge(
            [ FactoryOptions::HTTP_CLIENT => $client ],
            $this->getTerminalServiceDemoFactoryOptions()
        );
        /** @var TerminalService $terminal_service */
        $terminal_service = ServiceFactory::create(ApiServices::TERMINAL, $factory_options);
        $this->expectException(FidelyNetServiceException::class);
        $this->expectExceptionMessage(ApiMessages::CODES[$random_error]);
        $terminal_service->getCampaign(ApiDemoData::CAMPAIGN_ID);
    }
}
