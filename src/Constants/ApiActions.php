<?php

namespace Blabs\FidelyNet\Constants;

final class ApiActions
{
    const LOGIN = 'login';
    const GET_CAMPAIGN = 'getcampaign';
    const GET_MOVEMENTS = 'getmovements';

    const SYNCHRO = 'synchro';

    const VERIFY_EMAIL = 'verifyemail';
    const VERIFY_PHONE = 'verifyphone';
    const REGISTER_WITH_CODE = 'registrationvcwithverification';
    const REGISTER_WITHOUT_CODE = 'registrationvc';

    const BO_LOGIN = 'loginbo';
    const BO_MODIFY_CUSTOMER = 'modifycustomerbo';
    const BO_GET_INFO_CARD = 'getinfocardbo2';
    const BO_GET_DYNAMIC_FIELDS = 'getdynamicfieldsbo';
    const BO_GET_MOVEMENT_LIST = 'getmovementlistbo';
}
