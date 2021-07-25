<?php


namespace Blabs\FidelyNet\Responses\ResponseData;


use Spatie\DataTransferObject\DataTransferObject;

// Unused so far.
class ModifyCustomerResponseData extends DataTransferObject
{
    /** @var int $id */
    public $id;

    /** @var int $campaignId */
    public $campaignId;

    /** @var int $card */
    public $card;

    /** @var int $status */
    public $status;

    /** @var int $fidelyCode */
    public $fidelyCode;

    /** @var int $parentCustomerId */
    public $parentCustomerId;

    /** @var int $mlmCustomerId */
    public $mlmCustomerId;

    /** @var int $zoneId */
    public $zoneId;

    /** @var int $zoneForeignId */
    public $zoneForeignId;

    /** @var int $customer_area_status */
    public $customer_area_status;

    /** @var int $totalExchangedPrizes */
    public $totalExchangedPrizes;

    /** @var mixed $personalInfo */
    public $personalInfo;
}