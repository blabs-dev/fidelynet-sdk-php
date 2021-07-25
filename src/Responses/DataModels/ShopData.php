<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class ShopData extends DataTransferObject
{
    /**
     * 
     *
     * @var int $campaignId 
     */
    public $campaignId;

    /**
     * 
     *
     * @var int $shopId 
     */
    public $shopId;

    /**
     * 
     *
     * @var int $chargedPoints 
     */
    public $chargedPoints;

    /**
     * 
     *
     * @var int $dischargedPoints 
     */
    public $dischargedPoints;

    /**
     * 
     *
     * @var int $chargedCredits 
     */
    public $chargedCredits;

    /**
     * 
     *
     * @var int $dischargedCredits 
     */
    public $dischargedCredits;

    /**
     * 
     *
     * @var int $chargedCreditsGift 
     */
    public $chargedCreditsGift;

    /**
     * 
     *
     * @var int $dischargedCreditsGift 
     */
    public $dischargedCreditsGift;

    /**
     * 
     *
     * @var int $chargedPointsStatus 
     */
    public $chargedPointsStatus;

    /**
     * 
     *
     * @var int $dischargedPointsStatus 
     */
    public $dischargedPointsStatus;

    /**
     * 
     *
     * @var int $cardsCharged 
     */
    public $cardsCharged;

    /**
     * 
     *
     * @var int $cardsEmitted 
     */
    public $cardsEmitted;

    /**
     * 
     *
     * @var int $limitChargeCredits 
     */
    public $limitChargeCredits;

    /**
     * 
     *
     * @var int $limitChargeCreditsGift 
     */
    public $limitChargeCreditsGift;

    /**
     * 
     *
     * @var int $limitChargePoints 
     */
    public $limitChargePoints;

    /**
     * 
     *
     * @var int $limitDischargeCredits 
     */
    public $limitDischargeCredits;

    /**
     * 
     *
     * @var int $limitDischargeCreditsGift 
     */
    public $limitDischargeCreditsGift;

    /**
     * 
     *
     * @var int $limitDischargePoints 
     */
    public $limitDischargePoints;

    /**
     * 
     *
     * @var mixed $rights_shop 
     */
    public $rights_shop;

    /**
     * 
     *
     * @var mixed $behavior_flags 
     */
    public $behavior_flags;

    /**
     * 
     *
     * @var mixed $behavior_flags2 
     */
    public $behavior_flags2;

    /**
     * 
     *
     * @var mixed $operative_flags 
     */
    public $operative_flags;

    /**
     * 
     *
     * @var mixed $operative_flags2 
     */
    public $operative_flags2;

    /**
     * 
     *
     * @var int $balancePoints 
     */
    public $balancePoints;

    /**
     * 
     *
     * @var int $balanceCredits 
     */
    public $balanceCredits;

    /**
     * 
     *
     * @var int $balancePointsStatus 
     */
    public $balancePointsStatus;

    /**
     * 
     *
     * @var int $balanceCreditsGift 
     */
    public $balanceCreditsGift;

    /**
     * 
     *
     * @var int $balanceCards 
     */
    public $balanceCards;

    /**
     * 
     *
     * @var int $balanceCardsGift 
     */
    public $balanceCardsGift;

    /**
     * 
     *
     * @var int $cardsGiftCharged 
     */
    public $cardsGiftCharged;

    /**
     * 
     *
     * @var int $cardsGiftEmitted 
     */
    public $cardsGiftEmitted;
}
