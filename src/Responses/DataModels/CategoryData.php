<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class CategoryData extends DataTransferObject
{
    public int $id;
    public ?int $shopId;
    public ?int $weightPointValueMoney;
    public ?int $weightPointValuePoints;
    public ?int $weightChargeCreditMoney;
    public ?int $weightChargeCreditPoints;
    public ?int $weightChargePointMoney;
    public ?float $weightChargePointPoints;
    public ?int $weightDischargeCreditMoney;
    public ?int $weightDischargeCreditPoints;
    public ?int $weightExchangePrizePoints;
    public ?int $weightExchangePrizeMoney;
    public ?int $pointsInActivation;
    public ?int $initialCharge;
    public ?int $currencyId;
    public ?string $currencySymbol;
    public ?int $minLimitDischargePoint;
    public ?int $weightPointValueMoneyCashBack;
    public ?int $weightPointValuePointsCashBack;
    public ?int $code;
    public ?int $campaign;
    public string $name;
    public ?CategoryFlagsData $flags;
    public ?string $urlImage;
}
