<?php

namespace Blabs\FidelyNet\Responses\ResponseData;

use Spatie\DataTransferObject\DataTransferObject;

// Unused so far.
class CardInfoResponseData extends DataTransferObject
{
    /** @var int */
    public $id;

    /** @var int */
    public $campaignId;

    /** @var int */
    public $card;

    /** @var int */
    public $status;

    /** @var int */
    public $fidelyCode;

    /** @var int */
    public $parentCustomerId;

    /** @var int */
    public $mlmCustomerId;

    /** @var int */
    public $zoneId;

    /** @var int */
    public $zoneForeignId;

    /** @var int */
    public $customer_area_status;

    /** @var int */
    public $totalExchangedPrizes;

    /** @var mixed */
    public $personalInfo;

    /** @var int|null */
    public $totalMlmChildren;

    /** @var int|null */
    public $registration_shop_id;

    /** @var int|null */
    public $registration_net_id;

    /** @var int|null */
    public $registration_shop_foreign_id;

    /** @var int|null */
    public $registration_net_foreign_id;

    /** @var array|null */
    public $balanceData;

    /** @var int|null */
    public $customer_area_flags;
}