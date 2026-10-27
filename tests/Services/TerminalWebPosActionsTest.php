<?php

namespace Blabs\FidelyNet\Test\Services;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Responses\DataModels\BarcodeCardData;
use Blabs\FidelyNet\Responses\DataModels\WebPosMovementData;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Services\TerminalService;
use Blabs\FidelyNet\Test\ServiceTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

class TerminalWebPosActionsTest extends ServiceTestCase
{
    private array $history = [];

    /**
     * Builds a terminal service whose HTTP client answers with the given bodies (after the login one)
     * and records every request in $this->history.
     */
    private function service(string ...$bodies): TerminalService
    {
        $this->history = [];
        $queue = array_map(fn ($body) => new Response(200, [], $body), [
            $this->getFakeLoginResponse(ApiServices::TERMINAL),
            ...$bodies,
        ]);
        $stack = HandlerStack::create(new MockHandler($queue));
        $stack->push(Middleware::history($this->history));

        $options = array_merge(
            $this->getTerminalServiceDemoFactoryOptions(),
            [FactoryOptions::HTTP_CLIENT => new Client(['handler' => $stack])]
        );

        return ServiceFactory::create(ApiServices::TERMINAL, $options);
    }

    /**
     * Multipart fields sent by the last recorded request.
     */
    private function lastRequestFields(): array
    {
        $body = (string) end($this->history)['request']->getBody();
        preg_match('/boundary=(.+)$/', end($this->history)['request']->getHeaderLine('Content-Type'), $m);
        $fields = [];
        foreach (explode('--'.$m[1], $body) as $part) {
            if (preg_match('/name="([^"]+)"\r\n(?:[^\r\n]+\r\n)*\r\n(.*)\r\n$/s', $part, $f)) {
                $fields[$f[1]] = $f[2];
            }
        }

        return $fields;
    }

    private function fake(string $name): string
    {
        return $this->getFakeResponse(ApiServices::TERMINAL, $name);
    }

    public function test_action_constants_are_supported_by_the_terminal_service()
    {
        foreach ([
            ApiActions::TERM_GET_CARD_FROM_BARCODE => 'getcardfrombarcode',
            ApiActions::TERM_GET_INFO_BY_CARD      => 'getinfobycard',
            ApiActions::TERM_NEW_CARD              => 'newcard',
            ApiActions::TERM_CANCEL_LAST_TRANSACTION => 'cancellasttransaction',
            ApiActions::TERM_GET_LAST_MOVEMENTS    => 'getlastmovements',
        ] as $constant => $value) {
            $this->assertSame($value, $constant);
            $this->assertContains($constant, ApiServices::SUPPORTED_ACTIONS[ApiServices::TERMINAL]);
        }
    }

    public function test_get_card_from_barcode()
    {
        $service = $this->service($this->fake('getcardfrombarcode'));

        $card = $service->getCardFromBarcode('53164182296336');

        $this->assertInstanceOf(BarcodeCardData::class, $card);
        $this->assertSame(6056, $card->campaignCode);
        $this->assertSame(40000, $card->card);
        $this->assertSame('53164182296336', $card->barcode);
        $this->assertSame('60560004000086', $card->tmpBarcode);
        $fields = $this->lastRequestFields();
        $this->assertSame('getcardfrombarcode', $fields['az']);
        $this->assertSame('53164182296336', $fields['barcode']);
        $this->assertArrayHasKey('sessionid', $fields);
    }

    public function test_get_card_info_by_card_for_an_active_card()
    {
        $service = $this->service($this->fake('getinfobycard'));

        $info = $service->getCardInfoByCard(40000, 6056);

        $this->assertFalse($info->dormant);
        $this->assertSame(0, $info->returnCode);
        $this->assertSame(463943, $info->customer->id);
        $this->assertSame(2345, $info->customer->campaignId);
        $this->assertSame(12.5, $info->customer->balancePoints);
        $this->assertSame(3.75, $info->customer->balanceCredits);
        $fields = $this->lastRequestFields();
        $this->assertSame('getinfobycard', $fields['az']);
        $this->assertSame('40000', $fields['card']);
        $this->assertSame('6056', $fields['campaigncode']);
        $this->assertSame('N', $fields['flazzerapunti']);
    }

    public function test_get_card_info_by_card_treats_53_as_dormant_not_as_error()
    {
        $service = $this->service($this->fake('getinfobycard-dormant'));

        $info = $service->getCardInfoByCard(40000, 6056);

        $this->assertTrue($info->dormant);
        $this->assertSame(53, $info->returnCode);
        $this->assertSame(0, $info->customer->id);
        $this->assertSame(2345, $info->customer->campaignId);
        $this->assertSame(0, $info->customer->fidelyCode);
    }

    public function test_get_card_info_by_card_still_throws_on_other_codes()
    {
        $service = $this->service('{"returncode":"59","data":{}}');

        try {
            $service->getCardInfoByCard(2001000, 6039);
            $this->fail('Expected exception');
        } catch (FidelyNetServiceException $e) {
            $this->assertSame(59, $e->getServiceErrorCode());
        }
    }

    public function test_activate_card_sends_fixed_parameters()
    {
        $service = $this->service($this->fake('newcard'));

        $result = $service->activateCard(2345, 40000, '53164182296336');

        $this->assertSame(7250207, $result->customer->id);
        $this->assertSame(75810666, $result->movement->id);
        $this->assertSame(1, $result->movement->kind);
        $this->assertSame(65845, $result->movement->shopId);
        $this->assertSame(65845, $result->shop['id']);
        $fields = $this->lastRequestFields();
        $this->assertSame('newcard', $fields['az']);
        $this->assertSame('2345', $fields['campaignid']);
        $this->assertSame('40000', $fields['card']);
        $this->assertSame('53164182296336', $fields['fidelycode']);
        $this->assertSame('40000', $fields['username']);
        $this->assertSame('*', $fields['name']);
        $this->assertSame('*', $fields['surname']);
        $this->assertSame('N', $fields['gender']);
        $this->assertSame('0', $fields['parentcustomerid']);
        $this->assertSame('0', $fields['mlmcustomerid']);
        foreach (['birthdate', 'notes', 'address', 'geolevel1', 'geolevel5', 'customerdynamicfields', 'interestareas', 'facebookid'] as $empty) {
            $this->assertArrayHasKey($empty, $fields);
            $this->assertSame('', $fields[$empty]);
        }
    }

    /**
     * @dataProvider activationErrorCodes
     */
    public function test_activate_card_surfaces_error_codes(int $code)
    {
        $service = $this->service('{"returncode":"'.$code.'","data":{}}');

        try {
            $service->activateCard(2345, 40000, '');
            $this->fail('Expected exception');
        } catch (FidelyNetServiceException $e) {
            $this->assertSame($code, $e->getServiceErrorCode());
            $this->assertStringContainsString((string) $code, $e->getMessage());
        }
    }

    public function activationErrorCodes(): array
    {
        return [[58], [995], [56], [57], [1004], [360]];
    }

    public function test_cancel_last_transaction()
    {
        $service = $this->service($this->fake('cancellasttransaction'));

        $result = $service->cancelLastTransaction(7250207, 'test annullo');

        $this->assertSame(75810694, $result->movement->id);
        $this->assertSame(13, $result->movement->kind);
        $this->assertSame(1.0, $result->movement->totalMoney);
        $this->assertSame(0.05, $result->movement->chargedPoints);
        $fields = $this->lastRequestFields();
        $this->assertSame('cancellasttransaction', $fields['az']);
        $this->assertSame('7250207', $fields['customerid']);
        $this->assertSame('test annullo', $fields['notes']);
    }

    /**
     * @dataProvider cancelErrorCodes
     */
    public function test_cancel_last_transaction_surfaces_error_codes(int $code)
    {
        $service = $this->service('{"returncode":"'.$code.'","data":{}}');

        try {
            $service->cancelLastTransaction(1, '');
            $this->fail('Expected exception');
        } catch (FidelyNetServiceException $e) {
            $this->assertSame($code, $e->getServiceErrorCode());
        }
    }

    public function cancelErrorCodes(): array
    {
        return [[126], [133], [150], [1004]];
    }

    public function test_get_last_movements_wraps_single_object_in_a_list()
    {
        $service = $this->service($this->fake('getlastmovements'));

        $result = $service->getLastMovements(2345, 7250207, 0, 1);

        $this->assertCount(1, $result->movements);
        $movement = $result->movements[0];
        $this->assertInstanceOf(WebPosMovementData::class, $movement);
        $this->assertSame(75810694, $movement->id);
        $this->assertSame(1.5, $movement->totalMoney);
        $this->assertSame(0.25, $movement->chargedCredits);
        $this->assertSame(7250207, $result->customer->id);
        $fields = $this->lastRequestFields();
        $this->assertSame('getlastmovements', $fields['az']);
        $this->assertSame('2345', $fields['campaignid']);
        $this->assertSame('7250207', $fields['customerid']);
        $this->assertSame('0', $fields['initlimit']);
        $this->assertSame('1', $fields['rowcount']);
    }

    public function test_get_last_movements_with_array_and_empty()
    {
        $service = $this->service($this->fake('getlastmovements-multiple'), $this->fake('getlastmovements-empty'));

        $multiple = $service->getLastMovements(2345, 7250207, 0, 2);
        $this->assertCount(2, $multiple->movements);
        $this->assertSame([75810694, 75810666], array_map(fn ($m) => $m->id, $multiple->movements));

        $this->assertSame([], $service->getLastMovements(2345, 7250207, 0, 2)->movements);
    }

    public function test_string_zero_return_code_is_success_for_existing_actions()
    {
        $service = $this->service('{"returncode":"0","data":{"campagna_code":1,"card":2,"barcode":"3","tmpbarcode":"4"}}');

        $this->assertSame(2, $service->getCardFromBarcode('3')->card);
    }
}
