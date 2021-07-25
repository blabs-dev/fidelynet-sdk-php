<?php

namespace Blabs\FidelyNet\Constants;

use Blabs\FidelyNet\Providers\SessionId\InMemorySessionIdProvider;
use Blabs\FidelyNet\Services\BackofficeService;
use Blabs\FidelyNet\Services\CustomerService;
use Blabs\FidelyNet\Services\TerminalService;

final class FactoryOptions
{
    const SERVICE_TYPE = 'service';
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const TERMINAL = 'terminal';
    const CAMPAIGN_ID = 'campaign_id';
    const DEMO_MODE = 'demo_mode';

    const SESSION_PERSISTS = 'session_persists';
    const SESSION_ID_PROVIDER = 'session_id_provider';
    const SESSION_TYPE = 'session_type';
    const HTTP_CLIENT = 'http_client';
    const START_SESSION = 'start_session';

    const VALID_OPTIONS = [
        self::USERNAME,
        self::PASSWORD,
        self::TERMINAL,
        self::CAMPAIGN_ID,
        self::DEMO_MODE,
        self::SESSION_ID_PROVIDER,
        self::SESSION_TYPE,
        self::HTTP_CLIENT,
        self::START_SESSION,
    ];

    const SCHEMA = [
        ApiServices::CUSTOMER => [
            FactoryOptions::USERNAME,
            FactoryOptions::PASSWORD,
            FactoryOptions::CAMPAIGN_ID,
        ],
        ApiServices::TERMINAL => [
            FactoryOptions::USERNAME,
            FactoryOptions::PASSWORD,
            FactoryOptions::TERMINAL,
        ],
        ApiServices::BACKOFFICE => [
            FactoryOptions::USERNAME,
            FactoryOptions::PASSWORD,
        ],
        FactoryOptions::DEMO_MODE,
        FactoryOptions::SESSION_ID_PROVIDER,
        FactoryOptions::SESSION_TYPE,
        FactoryOptions::HTTP_CLIENT,
        FactoryOptions::START_SESSION,
    ];

    const SERVICE_CLASSES = [
        ApiServices::TERMINAL   => TerminalService::class,
        ApiServices::BACKOFFICE => BackofficeService::class,
        ApiServices::CUSTOMER   => CustomerService::class,
    ];

    const SERVICES_REQUIRED_OPTIONS = [
        ApiSessionTypes::PRIVATE => [
            ApiServices::TERMINAL => [
                self::USERNAME,
                self::PASSWORD,
                self::TERMINAL,
            ],
            ApiServices::BACKOFFICE => [
                self::USERNAME,
                self::PASSWORD,
            ],
            ApiServices::CUSTOMER => [
                self::USERNAME,
                self::PASSWORD,
                self::CAMPAIGN_ID,
            ],
        ],
        ApiSessionTypes::PUBLIC => [
            ApiServices::CUSTOMER => [
                self::CAMPAIGN_ID,
            ],
        ],
    ];

    const DEFAULT_VALUES = [
        self::DEMO_MODE           => false,
        self::SESSION_PERSISTS    => true,
        self::SESSION_ID_PROVIDER => InMemorySessionIdProvider::class,
        self::SESSION_TYPE        => ApiSessionTypes::PRIVATE,
        self::HTTP_CLIENT         => null,
        self::START_SESSION       => true,
    ];
}
