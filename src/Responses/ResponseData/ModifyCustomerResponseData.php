<?php

namespace Blabs\FidelyNet\Responses\ResponseData;

use Spatie\DataTransferObject\DataTransferObject;

// Unused so far.
class ModifyCustomerResponseData extends DataTransferObject
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
}
