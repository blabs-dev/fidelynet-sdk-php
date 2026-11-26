<?php

namespace Blabs\FidelyNet\Test\Session;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Responses\DataModels\OperatorProfileData;
use Blabs\FidelyNet\ServiceFactory;
use Blabs\FidelyNet\Services\TerminalService;
use Blabs\FidelyNet\Providers\SessionId\InMemorySessionIdProvider;
use Blabs\FidelyNet\Test\ServiceTestCase;

class OperatorProfileTest extends ServiceTestCase
{
    public function test_terminal_login_exposes_the_operator_and_its_profile()
    {
        $service = $this->terminalService([$this->getFakeLoginResponse(ApiServices::TERMINAL)]);

        $operator = $service->getLoggedOperator();
        $this->assertNotNull($operator);
        $this->assertSame(3631, $operator->id);
        $this->assertSame('UtenteTerminale', $operator->username);

        $profile = $service->getOperatorProfile();
        $this->assertInstanceOf(OperatorProfileData::class, $profile);
        $this->assertSame(264241151, $profile->rights);
        $this->assertTrue($profile->canDoNewCard);
        $this->assertFalse($profile->canChargePoints);
        $this->assertFalse($profile->canChargeCredits);
    }

    public function test_profile_reports_an_operator_allowed_to_charge_points()
    {
        $service = $this->terminalService([$this->loginWithProfile(['canChargePoints' => true, 'canChargeCredits' => false])]);

        $this->assertTrue($service->getOperatorProfile()->canChargePoints);
        $this->assertFalse($service->getOperatorProfile()->canChargeCredits);
    }

    public function test_a_permission_missing_from_the_reply_reads_as_false()
    {
        $service = $this->terminalService([$this->loginWithProfile(null, ['canDoSale' => true])]);

        $profile = $service->getOperatorProfile();
        $this->assertTrue($profile->canDoSale);
        $this->assertFalse($profile->canChargePoints);
        $this->assertSame(0, $profile->rights);
    }

    public function test_a_login_without_profile_gives_no_profile()
    {
        $service = $this->terminalService([$this->loginWithProfile(null, [])]);

        $this->assertNotNull($service->getLoggedOperator());
        $this->assertNull($service->getOperatorProfile());
    }

    public function test_a_resumed_session_made_no_login_and_has_no_profile()
    {
        $ids = new InMemorySessionIdProvider();
        $ids->setSessionId('resumed-session');

        $service = $this->terminalService([], $ids);

        $this->assertSame('resumed-session', $service->getSessionId());
        $this->assertNull($service->getLoggedOperator());
        $this->assertNull($service->getOperatorProfile());
    }

    public function test_a_session_renewal_refreshes_the_profile()
    {
        $service = $this->terminalService([
            $this->getFakeLoginResponse(ApiServices::TERMINAL),
            $this->getFakeExpiredSessionResponse(),
            $this->loginWithProfile(['canChargePoints' => true]),
            $this->getFakeResponse(ApiServices::TERMINAL, ApiActions::TERM_GET_CAMPAIGN),
        ]);

        $this->assertFalse($service->getOperatorProfile()->canChargePoints);
        $service->getCampaign('1001');
        $this->assertTrue($service->getOperatorProfile()->canChargePoints);
    }

    private function terminalService(array $bodies, ?InMemorySessionIdProvider $ids = null): TerminalService
    {
        $options = $this->getTerminalServiceDemoFactoryOptions();
        $options[FactoryOptions::HTTP_CLIENT] = $this->mockClient($bodies);
        $options[FactoryOptions::SESSION_PERSISTS] = false;

        if ($ids !== null) {
            $options[FactoryOptions::SESSION_ID_PROVIDER] = $ids;
        }

        return ServiceFactory::create(ApiServices::TERMINAL, $options);
    }

    /**
     * @param array|null $overrides merged into the fixture profile
     * @param array|null $profile   replaces the profile entirely when given
     */
    private function loginWithProfile(?array $overrides, ?array $profile = null): string
    {
        $data = json_decode($this->getFakeLoginResponse(ApiServices::TERMINAL), true);
        $data['data']['operator']['profile'] = $profile ?? array_merge($data['data']['operator']['profile'], $overrides ?? []);

        return json_encode($data);
    }
}
