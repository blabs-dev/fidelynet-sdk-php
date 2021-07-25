<?php

namespace Blabs\FidelyNet\Constants;

final class ApiServices
{
    const TERMINAL = 'terminal';
    const BACKOFFICE = 'backoffice';
    const CUSTOMER = 'customer';

    const ENTRYPOINTS = [
        self::TERMINAL   => 'https://service.fidelynet.it/webpos/services/webposservice.php',
        self::BACKOFFICE => 'https://service.fidelynet.it/webpos/services/webposservice.php',
        self::CUSTOMER   => 'https://service.fidelynet.it/webpos/services/customerservice.php',
    ];

    const SUPPORTED_ACTIONS = [
        self::TERMINAL => [
            ApiActions::GET_CAMPAIGN,
        ],
        self::BACKOFFICE => [
            ApiActions::BO_MODIFY_CUSTOMER,
            ApiActions::BO_GET_INFO_CARD,
        ],
        self::CUSTOMER   => [
            ApiActions::VERIFY_EMAIL,
            ApiActions::REGISTER_WITH_CODE,
            ApiActions::REGISTER_WITHOUT_CODE,
            ApiActions::GET_MOVEMENTS,
        ],
    ];
}
