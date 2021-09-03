<?php

namespace Blabs\FidelyNet\Test\Support;

use Blabs\FidelyNet\Support\UserAgentHelper;
use Blabs\FidelyNet\Support\VersionHelper;
use PHPUnit\Framework\TestCase;

class UserAgentHelperTest extends TestCase
{
    public function test_user_agent_contains_release_version()
    {
        $currentVersion = VersionHelper::getCurrentVersion();
        $userAgentStamp = UserAgentHelper::getUserAgent();
        $this->assertStringContainsString($currentVersion, $userAgentStamp);
    }
}
