<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class ShopData extends DataTransferObject
{
    /**
     * @var int
     */
    public $campaignId;

    /**
     * @var int
     */
    public $shopId;

    /**
     * @var int
     */
    public $chargedPoints;

    /**
     * @var int
     */
    public $dischargedPoints;

    /**
     * @var int
     */
    public $chargedCredits;

    /**
     * @var int
     */
    public $dischargedCredits;

    /**
     * @var int
     */
    public $chargedCreditsGift;

    /**
     * @var int
     */
    public $dischargedCreditsGift;

    /**
     * @var int
     */
    public $chargedPointsStatus;

    /**
     * @var int
     */
    public $dischargedPointsStatus;

    /**
     * @var int
     */
    public $cardsCharged;

    /**
     * @var int
     */
    public $cardsEmitted;

    /**
     * @var int
     */
    public $limitChargeCredits;

    /**
     * @var int
     */
    public $limitChargeCreditsGift;

    /**
     * @var int
     */
    public $limitChargePoints;

    /**
     * @var int
     */
    public $limitDischargeCredits;

    /**
     * @var int
     */
    public $limitDischargeCreditsGift;

    /**
     * @var int
     */
    public $limitDischargePoints;

    /**
     * @var mixed
     */
    public $rights_shop;

    /**
     * @var mixed
     */
    public $behavior_flags;

    /**
     * @var mixed
     */
    public $behavior_flags2;

    /**
     * @var mixed
     */
    public $operative_flags;

    /**
     * @var mixed
     */
    public $operative_flags2;

    /**
     * @var int
     */
    public $balancePoints;

    /**
     * @var int
     */
    public $balanceCredits;

    /**
     * @var int
     */
    public $balancePointsStatus;

    /**
     * @var int
     */
    public $balanceCreditsGift;

    /**
     * @var int
     */
    public $balanceCards;

    /**
     * @var int
     */
    public $balanceCardsGift;

    /**
     * @var int
     */
    public $cardsGiftCharged;

    /**
     * @var int
     */
    public $cardsGiftEmitted;
}
