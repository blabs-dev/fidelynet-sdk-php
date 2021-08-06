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
     * @var int
     */
    public int $campaignId;
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
     * @var int
     */
    public int $parentCustomerId;
    /**
     * @var int
     */
    public int $mlmCustomerId;
    /**
     * @var int
     */
    public int $zoneId;
    /**
     * @var int
     */
    public int $zoneForeignId;
    /**
     * @var int
     */
    public int $customer_area_status;
    /**
     * @var int
     */
    public int $totalExchangedPrizes;
    /**
     * @var PersonalInfoData
     */
    public PersonalInfoData $personalInfo;
}
