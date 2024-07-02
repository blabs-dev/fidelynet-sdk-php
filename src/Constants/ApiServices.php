<?php

namespace Blabs\FidelyNet\Constants;

final class ApiServices
{
    const TERMINAL = 'terminal';
    const TERMINAL_MOBILE = 'terminal-mobile';
    const BACKOFFICE = 'backoffice';
    const CUSTOMER = 'customer';

    const ENTRYPOINTS = [
        self::TERMINAL          => 'https://service.fidelynet.it/webpos/services/webposservice.php',
        self::BACKOFFICE        => 'https://service.fidelynet.it/webpos/services/webposservice.php',
        self::CUSTOMER          => 'https://service.fidelynet.it/webpos/services/customerservice.php',
        self::TERMINAL_MOBILE   => 'https://service.fidelynet.it/webpos/services/mobileservice.php',
    ];

    const SUPPORTED_ACTIONS = [
        self::TERMINAL => [
            ApiActions::TERM_GET_CAMPAIGN,
            ApiActions::TERM_GET_CATEGORIES,
            ApiActions::TERM_CHECK_CARD,
        ],
        self::BACKOFFICE => [
            ApiActions::BO_MODIFY_CUSTOMER,
            ApiActions::BO_MODIFY_USERNAME_AND_PASSWORD,
            ApiActions::BO_MODIFY_PIN_CODE,
            ApiActions::BO_GET_INFO_CARD,
            ApiActions::BO_GET_DYNAMIC_FIELDS,
            ApiActions::BO_GET_MOVEMENT_LIST,
            ApiActions::BO_GET_SHOP_CATEGORIES,
            ApiActions::BO_GET_SHOPS,
            ApiActions::BO_MERGE_CARDS,
        ],
        self::CUSTOMER   => [
            ApiActions::VERIFY_EMAIL,
            ApiActions::REGISTER_WITH_CODE,
            ApiActions::REGISTER_WITHOUT_CODE,
            ApiActions::GET_MOVEMENTS,
            ApiActions::GET_GEO_LEVELS,
        ],
    ];

    const ACTIONS_THAT_USES_SESSION_PARAMETER = [
        ApiActions::BO_GET_DYNAMIC_FIELDS,
    ];
    const ACTIONS_THAT_DOES_NOT_USE_SESSION_PARAMETER = [
        ApiActions::TERM_CHECK_CARD,
    ];
}
