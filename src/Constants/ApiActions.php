<?php

namespace Blabs\FidelyNet\Constants;

final class ApiActions
{
    const LOGIN = 'login';
    const GET_MOVEMENTS = 'getmovements';

    const SYNCHRO = 'synchro';

    const VERIFY_EMAIL = 'verifyemail';
    const VERIFY_PHONE = 'verifyphone';
    const REGISTER_WITH_CODE = 'registrationvcwithverification';
    const REGISTER_WITHOUT_CODE = 'registrationvc';

    const BO_LOGIN = 'loginbo';
    const BO_MODIFY_CUSTOMER = 'modifycustomerbo';
    const BO_MODIFY_USERNAME_AND_PASSWORD = 'modifyusernameandpasswordbo';
    const BO_GET_INFO_CARD = 'getinfocardbo2';
    const BO_GET_DYNAMIC_FIELDS = 'getdynamicfieldsbo';
    const BO_GET_MOVEMENT_LIST = 'getmovementlistbo';
    const BO_GET_SHOP_CATEGORIES = 'getshopcategoriesbo';
    const BO_GET_SHOPS = 'getshopsbo';

    const TERM_GET_CAMPAIGN = 'getcampaign';
    const TERM_GET_CATEGORIES = 'getcategories';
    const TERM_CHECK_CARD = 'checkcard';
}
