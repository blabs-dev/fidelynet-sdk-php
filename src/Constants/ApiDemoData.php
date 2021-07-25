<?php

namespace Blabs\FidelyNet\Constants;

final class ApiDemoData
{
    // A set of fake credentials used for testing purposes

    const BACKOFFICE_USER = 'OperatoreBO';
    const BACKOFFICE_PASSWORD = '123456';

    const TERMINAL_USERNAME = 'UtenteTerminale';
    const TERMINAL_PASSWORD = self::BACKOFFICE_PASSWORD;
    const TERMINAL_SERIAL = '1234567890';

    const CUSTOMER_USERNAME = '1';
    const CUSTOMER_PASSWORD = '12345678';

    const CAMPAIGN_ID = '1001';
    const CATEGORY_ID = '1001';
}
