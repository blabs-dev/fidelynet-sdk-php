<?php

namespace Blabs\FidelyNet\Responses\ResponseData;

use Spatie\DataTransferObject\DataTransferObject;

final class CardInfoResponseData extends DataTransferObject
{
    /** @var int */
    public int $id;

    /** @var int */
    public int $campaignId;

    /** @var int */
    public int $card;

    /** @var int */
    public int $status;

    /** @var int */
    public int $fidelyCode;

    /** @var int */
    public ?int $parentCustomerId;

    /** @var int */
    public ?int $mlmCustomerId;

    /** @var int */
    public ?int $zoneId;

    /** @var int */
    public ?int $zoneForeignId;

    /** @var int */
    public ?int $customer_area_status;

    /** @var int */
    public ?int $totalExchangedPrizes;

    /** @var mixed */
    public mixed $personalInfo;

    /** @var int|null */
    public ?int $totalMlmChildren;

    /** @var int|null */
    public ?int $registration_shop_id;

    /** @var int|null */
    public ?int $registration_net_id;

    /** @var int|null */
    public ?int $registration_shop_foreign_id;

    /** @var int|null */
    public ?int $registration_net_foreign_id;

    /** @var array|null */
    public ?array $balanceData;

    /** @var int|null */
    public ?int $customer_area_flags;
}
