<?php


namespace Blabs\FidelyNet\Constants;


final class ApiServices
{
    const TERMINAL = 'terminal';
    const BACKOFFICE = 'backoffice';
    const CUSTOMER = 'customer';

    const ENTRYPOINTS = [
        self::TERMINAL => 'https://service.fidely.net/webpos/services/webposservice.php',
        self::BACKOFFICE => 'https://service.fidely.net/webpos/services/webposservice.php',
        self::CUSTOMER => 'https://service.fidely.net/webpos/services/customerservice.php'
    ];

    const SUPPORTED_ACTIONS = [
        self::TERMINAL => [
            ApiActions::GET_CAMPAIGN
        ],
        self::BACKOFFICE => [],
        self::CUSTOMER => [
            ApiActions::VERIFY_EMAIL,
            ApiActions::REGISTER_WITH_VC,
            ApiActions::GET_MOVEMENTS,
        ],
    ];
}
