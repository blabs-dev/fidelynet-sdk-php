<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class OperatorProfileData extends DataTransferObject
{
    /**
     * @var int
     */
    public int $rights;

    /**
     * @var bool
     */
    public bool $canDoNewCard;

    /**
     * @var bool
     */
    public bool $canChargeCredits;

    /**
     * @var bool
     */
    public bool $canDischargeCredits;

    /**
     * @var bool
     */
    public bool $canChargePoints;

    /**
     * @var bool
     */
    public bool $canDischargePoints;

    /**
     * @var bool
     */
    public bool $canDoSale;

    /**
     * @var bool
     */
    public bool $canApplyDiscount;

    /**
     * @var bool
     */
    public bool $canAcceptVouchers;

    /**
     * @var bool
     */
    public bool $canDeliverPromotions;

    /**
     * @var bool
     */
    public bool $canLockCard;

    /**
     * @var bool
     */
    public bool $canUnlockCard;

    /**
     * @var bool
     */
    public bool $canReplaceCard;

    /**
     * @var bool
     */
    public bool $canSearchCustomer;

    /**
     * @var bool
     */
    public bool $canExchangePrizes;

    /**
     * @var bool
     */
    public bool $canDeliverPrizes;

    /**
     * @var bool
     */
    public bool $canExtendExpirationDate;

    /**
     * @var bool
     */
    public bool $canModifyCategory;

    /**
     * @var bool
     */
    public bool $canDeliverStatusPoints;

    /**
     * @var bool
     */
    public bool $canRequestPoints;

    /**
     * @var bool
     */
    public bool $canCancelTransaction;

    /**
     * @var bool
     */
    public bool $canTransferPoints;

    /**
     * @var bool
     */
    public bool $canCancelOtherTerminalTransactions;

    /**
     * @var bool
     */
    public bool $canCancelTransactionById;

    /**
     * @var bool
     */
    public bool $canLockCustomers;

    /**
     * @var bool
     */
    public bool $canUnlockCustomers;

    /**
     * @var bool
     */
    public bool $canModifyCustomer;

    /**
     * @var bool
     */
    public bool $canDoCheckIn;

    /**
     * @var bool
     */
    public bool $canDoCheckOut;
}
