<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class CustomerInfoData extends DataTransferObject
{
    /**
     * @var int
     */
    public int $id;
    /**
     * @var int|null
     */
    public ?int $campaignId;
    /**
     * @var int
     */
    public int $card;
    /**
     * @var int
     */
    public int $status;
    /**
     * @var int
     */
    public int $fidelyCode;
    /**
     * @var int|null
     */
    public ?int $parentCustomerId;
    /**
     * @var int|null
     */
    public ?int $mlmCustomerId;
    /**
     * @var int|null
     */
    public ?int $zoneId;
    /**
     * @var int|null
     */
    public ?int $zoneForeignId;
    /**
     * @var int
     */
    public int $customer_area_status;
    /**
     * @var int|null
     */
    public ?int $totalExchangedPrizes;
    /**
     * @var PersonalInfoData|null
     */
    public ?PersonalInfoData $personalInfo;
}
