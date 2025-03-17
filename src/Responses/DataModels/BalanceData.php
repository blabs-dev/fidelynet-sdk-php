<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

class BalanceData extends DataTransferObject
{
//  {
//                    "category": 1703,
//                    "status": 1,
//                    "cardType": 0,
//                    "pointsCharged": 5.35,
//                    "pointsUsed": 0,
//                    "creditsCharged": 0,
//                    "creditsUsed": 0,
//                    "creditsGiftCharged": 0,
//                    "creditsGiftUsed": 0,
//                    "rechargesCard": 1,
//                    "usesCard": 0,
//                    "balance_points": 5.35,
//                    "balance_credits": 0,
//                    "balance_gift_credits": 0,
//                    "total_money_in_sale": 0,
//                    "paid_money_in_sale": 0,
//                    "pointsChargedCount": 0,
//                    "pointsUsedCount": 0,
//                    "creditsUsedCount": 0,
//                    "creditsGiftUsedCount": 0,
//                    "balance_individual_points": 5
//                }

    public int $category;
    public int $status;
    public int $cardType;

    public ?float $pointsCharged;
    public ?float $pointsUsed;
    public ?float $creditsCharged;
    public ?float $creditsUsed;
    public ?float $creditsGiftCharged;
    public ?float $creditsGiftUsed;
    public ?float $rechargesCard;
    public ?float $usesCard;
    public ?float $balance_points;
    public ?float $balance_credits;
    public ?float $balance_gift_credits;
    public ?float $total_money_in_sale;
    public ?float $paid_money_in_sale;
    public ?float $pointsChargedCount;
    public ?float $pointsUsedCount;
    public ?float $creditsUsedCount;
    public ?float $creditsGiftUsedCount;
    public ?float $balance_individual_points;
}