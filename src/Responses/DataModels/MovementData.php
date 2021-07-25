<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

class MovementData extends DataTransferObject
{
    /** @var int $id */
    public $id;

    /** @var int $campaign */
    public $campaign;

    /** @var int $terminal */
    public $terminal;

    /** @var int $card */
    public $card;

    /** @var int $cardOld */
    public $cardOld;

    /** @var int $kind */
    public $kind;

    /** @var int $customer */
    public $customer;

    /** @var int $operator */
    public $operator;

    /** @var string $dateTime */
    public $dateTime;

    /** @var string $localTime */
    public $localTime;

    /** @var int $chargedCredits */
    public $chargedCredits;

    /** @var int $dischargedCredits */
    public $dischargedCredits;

    /** @var int $chargedGiftCredits */
    public $chargedGiftCredits;

    /** @var int $dischargedGiftCredits */
    public $dischargedGiftCredits;

    /** @var double|int $chargedPoints */
    public $chargedPoints;

    /** @var int $dischargedPoints */
    public $dischargedPoints;

    /** @var int $chargedPointsStatus */
    public $chargedPointsStatus;

    /** @var int $dischargedPointsStatus */
    public $dischargedPointsStatus;

    /** @var int $currencyConversion */
    public $currencyConversion;

    /** @var int $profitMoneyLocal */
    public $profitMoneyLocal;

    /** @var int $totalMoney */
    public $totalMoney;

    /** @var int $totalBenefits */
    public $totalBenefits;

    /** @var int $discount */
    public $discount;

    /** @var mixed $shop */
    public $shop;

    /** @var int $shopId */
    public $shopId;

    /** @var mixed $category */
    public $category;

    /** @var int $kindCharge */
    public $kindCharge;

    /** @var mixed $periodId */
    public $periodId;

    /** @var mixed $flags */
    public $flags;

    /** @var int $promotionErrorCode */
    public $promotionErrorCode;

    /** @var int $sellerId */
    public $sellerId;
}
