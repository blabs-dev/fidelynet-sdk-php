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
    const GET_GEO_LEVELS = 'getgeolevels';
    const BO_LOGIN = 'loginbo';
    const BO_MODIFY_CUSTOMER = 'modifycustomerbo';
    const BO_MODIFY_USERNAME_AND_PASSWORD = 'modifyusernameandpasswordbo';
    const BO_MODIFY_PIN_CODE = 'modifypincodebo';
    const BO_GET_INFO_CARD = 'getinfocardbo2';
    const BO_GET_DYNAMIC_FIELDS = 'getdynamicfieldsbo';
    const BO_GET_MOVEMENT_LIST = 'getmovementlistbo';

    const BO_GET_ALL_MOVEMENTS = 'getmovementlistbofull';
    const BO_GET_SHOP_CATEGORIES = 'getshopcategoriesbo';
    const BO_GET_SHOPS = 'getshopsbo';
    const BO_MERGE_CARDS = 'mergecustomerfidelybo';

    const TERM_GET_CAMPAIGN = 'getcampaign';
    const TERM_GET_CATEGORIES = 'getcategories';
    const TERM_CHECK_CARD = 'checkcard';
    const TERM_GET_LOGGED_SHOP_INFO = 'getinfoshop';
    const TERM_GET_CARD_INFO = 'getinfo';
    const TERM_CHARGE_POINTS = 'chargepoints';
    const TERM_DISCHARGE_POINTS = 'dischargepoints';
    const TERM_SALE_PRODUCT = 'saleproduct';
}
