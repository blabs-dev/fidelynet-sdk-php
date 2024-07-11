<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class MovementData extends DataTransferObject
{
    /** @var int */
    public int $id;

    /** @var int */
    public int $campaign;

    /** @var int */
    public int $terminal;

    /** @var int */
    public int $card;

    /** @var mixed */
    public mixed $cardOld;

    /** @var int */
    public int $kind;

    /** @var int */
    public int $customer;

    /** @var int|null */
    public ?int $operator;

    /** @var string */
    public string $dateTime;

    /** @var string */
    public string $localTime;

    /** @var int */
    public int $chargedCredits;

    /** @var int */
    public int $dischargedCredits;

    /** @var int */
    public int $chargedGiftCredits;

    /** @var int */
    public int $dischargedGiftCredits;

    /** @var float|int */
    public int|float $chargedPoints;

    /** @var int */
    public int $dischargedPoints;

    /** @var int */
    public int $chargedPointsStatus;

    /** @var int */
    public int $dischargedPointsStatus;

    /** @var int|null */
    public ?int $currencyConversion;

    /** @var int|null */
    public ?int $profitMoneyLocal;

    /** @var int */
    public int $totalMoney;

    /** @var int */
    public int $totalBenefits;

    /** @var int */
    public int $discount;

    /** @var MovementShopData|null */
    public ?MovementShopData $shop;

    /** @var int */
    public int $shopId;

    /** @var mixed */
    public mixed $category;

    /** @var int */
    public int $kindCharge;

    /** @var mixed */
    public mixed $periodId;

    /** @var mixed */
    public mixed $flags;

    /** @var int */
    public int $promotionErrorCode;

    /** @var int */
    public int $sellerId;
}
