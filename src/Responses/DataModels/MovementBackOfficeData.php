<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

class MovementBackOfficeData extends DataTransferObject
{
    public int $id;
    public int $campaign;
    public int $terminal;
    public int $shopId;
    public int $card;
    public int $cardOld;
    public int $kind;
    public ?string $kindDescription;
    public int $customer;
    public string $customerName;
    public string $customerSurname;
    public int $operatorId;
    public string $dateTime;
    public string $localTime;
    public int $chargedCredits;
    public int $chargedGiftCredits;
    public int $chargedPoints;
    public int $chargedPointsStatus;
    public int $dischargedCredits;
    public int $dischargedGiftCredits;
    public int $dischargedPoints;
    public int $dischargedPointsStatus;
    public int $currencyConversion;
    public int $profitMoneyLocal;
    public int $totalMoney;
    public int $totalBenefits;
    public int $discount;
    public int $paymentMethodId;
    public $shop;
    public $categoryId;
    public int $kindCharge;
    public $periodId;
    public $flags;
    public $productList;
    public int $promotionErrorCode;
    public int $sellerId;
}
