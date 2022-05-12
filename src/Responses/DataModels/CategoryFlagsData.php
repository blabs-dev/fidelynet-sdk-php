<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class CategoryFlagsData extends DataTransferObject
{
    public ?int $flags;
    public ?bool $isGIFT;
    public ?bool $deliverPointsInChargeCredits;
    public ?bool $deliverPointsInDischargeCredits;
    public ?bool $deliverPointsInSale;
    public ?bool $deliverPointsInActivation;
    public ?bool $showPointsInActivationTicket;
    public ?bool $showMoney4PointsInTicket;
    public ?bool $useExpirationCard;
    public ?bool $customerOnlyAllowInActivationShop;
    public ?bool $registerActivationPointsInCampaign;
    public ?bool $onlyOneUse;
    public ?bool $sellerCategory;
    public ?bool $checkMinimalLimitDischargePoints;
    public ?bool $checkCanNotTransaction;
    public ?bool $dealerCategory;
    public ?bool $deliverPointsInCashback;
}
