<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

class MovementData extends DataTransferObject
{
    /** @var int */
    public $id;

    /** @var int */
    public $campaign;

    /** @var int */
    public $terminal;

    /** @var int */
    public $card;

    /** @var int */
    public $cardOld;

    /** @var int */
    public $kind;

    /** @var int */
    public $customer;

    /** @var int */
    public $operator;

    /** @var string */
    public $dateTime;

    /** @var string */
    public $localTime;

    /** @var int */
    public $chargedCredits;

    /** @var int */
    public $dischargedCredits;

    /** @var int */
    public $chargedGiftCredits;

    /** @var int */
    public $dischargedGiftCredits;

    /** @var float|int */
    public $chargedPoints;

    /** @var int */
    public $dischargedPoints;

    /** @var int */
    public $chargedPointsStatus;

    /** @var int */
    public $dischargedPointsStatus;

    /** @var int */
    public $currencyConversion;

    /** @var int */
    public $profitMoneyLocal;

    /** @var int */
    public $totalMoney;

    /** @var int */
    public $totalBenefits;

    /** @var int */
    public $discount;

    /** @var mixed */
    public $shop;

    /** @var int */
    public $shopId;

    /** @var mixed */
    public $category;

    /** @var int */
    public $kindCharge;

    /** @var mixed */
    public $periodId;

    /** @var mixed */
    public $flags;

    /** @var int */
    public $promotionErrorCode;

    /** @var int */
    public $sellerId;
}
