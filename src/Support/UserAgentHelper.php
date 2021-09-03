<?php

namespace Blabs\FidelyNet\Support;

class UserAgentHelper
{

    const USER_AGENT_PREFIX = 'B@Labs FidelyNET Client v';

    public static function getUserAgent(): string
    {
        return self::USER_AGENT_PREFIX . VersionHelper::getCurrentVersion();
    }
}