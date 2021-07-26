<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class ShopData extends DataTransferObject
{
    /**
     * @var int
     */
    public int $campaignId;

    /**
     * @var int
     */
    public int $shopId;

    /**
     * @var int
     */
    public int $chargedPoints;

    /**
     * @var int
     */
    public int $dischargedPoints;

    /**
     * @var int
     */
    public int $chargedCredits;

    /**
     * @var int
     */
    public int $dischargedCredits;

    /**
     * @var int
     */
    public int $chargedCreditsGift;

    /**
     * @var int
     */
    public int $dischargedCreditsGift;

    /**
     * @var int
     */
    public int $chargedPointsStatus;

    /**
     * @var int
     */
    public int $dischargedPointsStatus;

    /**
     * @var int
     */
    public int $cardsCharged;

    /**
     * @var int
     */
    public int $cardsEmitted;

    /**
     * @var int
     */
    public int $limitChargeCredits;

    /**
     * @var int
     */
    public int $limitChargeCreditsGift;

    /**
     * @var int
     */
    public int $limitChargePoints;

    /**
     * @var int
     */
    public int $limitDischargeCredits;

    /**
     * @var int
     */
    public int $limitDischargeCreditsGift;

    /**
     * @var int
     */
    public int $limitDischargePoints;

    /**
     * @var mixed
     */
    public mixed $rights_shop;

    /**
     * @var mixed
     */
    public mixed $behavior_flags;

    /**
     * @var mixed
     */
    public mixed $behavior_flags2;

    /**
     * @var mixed
     */
    public mixed $operative_flags;

    /**
     * @var mixed
     */
    public mixed $operative_flags2;

    /**
     * @var int
     */
    public int $balancePoints;

    /**
     * @var int
     */
    public int $balanceCredits;

    /**
     * @var int
     */
    public int $balancePointsStatus;

    /**
     * @var int
     */
    public int $balanceCreditsGift;

    /**
     * @var int
     */
    public int $balanceCards;

    /**
     * @var int
     */
    public int $balanceCardsGift;

    /**
     * @var int
     */
    public int $cardsGiftCharged;

    /**
     * @var int
     */
    public int $cardsGiftEmitted;
}
