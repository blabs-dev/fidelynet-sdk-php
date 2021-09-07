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
            ApiActions::BO_GET_DYNAMIC_FIELDS,
            ApiActions::BO_GET_MOVEMENT_LIST,
        ],
        self::CUSTOMER   => [
            ApiActions::VERIFY_EMAIL,
            ApiActions::REGISTER_WITH_CODE,
            ApiActions::REGISTER_WITHOUT_CODE,
            ApiActions::GET_MOVEMENTS,
        ],
    ];

    const ACTIONS_THAT_USES_SESSION_PARAMETER = [
        ApiActions::BO_GET_DYNAMIC_FIELDS,
    ];
}
