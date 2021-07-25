<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class OperatorProfileData extends DataTransferObject
{
    /**
     * @var int
     */
    public $rights;

    /**
     * @var bool
     */
    public $canDoNewCard;

    /**
     * @var bool
     */
    public $canChargeCredits;

    /**
     * @var bool
     */
    public $canDischargeCredits;

    /**
     * @var bool
     */
    public $canChargePoints;

    /**
     * @var bool
     */
    public $canDischargePoints;

    /**
     * @var bool
     */
    public $canDoSale;

    /**
     * @var bool
     */
    public $canApplyDiscount;

    /**
     * @var bool
     */
    public $canAcceptVouchers;

    /**
     * @var bool
     */
    public $canDeliverPromotions;

    /**
     * @var bool
     */
    public $canLockCard;

    /**
     * @var bool
     */
    public $canUnlockCard;

    /**
     * @var bool
     */
    public $canReplaceCard;

    /**
     * @var bool
     */
    public $canSearchCustomer;

    /**
     * @var bool
     */
    public $canExchangePrizes;

    /**
     * @var bool
     */
    public $canDeliverPrizes;

    /**
     * @var bool
     */
    public $canExtendExpirationDate;

    /**
     * @var bool
     */
    public $canModifyCategory;

    /**
     * @var bool
     */
    public $canDeliverStatusPoints;

    /**
     * @var bool
     */
    public $canRequestPoints;

    /**
     * @var bool
     */
    public $canCancelTransaction;

    /**
     * @var bool
     */
    public $canTransferPoints;

    /**
     * @var bool
     */
    public $canCancelOtherTerminalTransactions;

    /**
     * @var bool
     */
    public $canCancelTransactionById;

    /**
     * @var bool
     */
    public $canLockCustomers;

    /**
     * @var bool
     */
    public $canUnlockCustomers;

    /**
     * @var bool
     */
    public $canModifyCustomer;

    /**
     * @var bool
     */
    public $canDoCheckIn;

    /**
     * @var bool
     */
    public $canDoCheckOut;
}
