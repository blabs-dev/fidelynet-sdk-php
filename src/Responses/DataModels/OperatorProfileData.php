<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class OperatorProfileData extends DataTransferObject
{
    /**
     * 
     *
     * @var int $rights 
     */
    public $rights;

    /**
     * 
     *
     * @var bool $canDoNewCard 
     */
    public $canDoNewCard;

    /**
     * 
     *
     * @var bool $canChargeCredits 
     */
    public $canChargeCredits;

    /**
     * 
     *
     * @var bool $canDischargeCredits 
     */
    public $canDischargeCredits;

    /**
     * 
     *
     * @var bool $canChargePoints 
     */
    public $canChargePoints;

    /**
     * 
     *
     * @var bool $canDischargePoints 
     */
    public $canDischargePoints;

    /**
     * 
     *
     * @var bool $canDoSale 
     */
    public $canDoSale;

    /**
     * 
     *
     * @var bool $canApplyDiscount 
     */
    public $canApplyDiscount;

    /**
     * 
     *
     * @var bool $canAcceptVouchers 
     */
    public $canAcceptVouchers;

    /**
     * 
     *
     * @var bool $canDeliverPromotions 
     */
    public $canDeliverPromotions;

    /**
     * 
     *
     * @var bool $canLockCard 
     */
    public $canLockCard;

    /**
     * 
     *
     * @var bool $canUnlockCard 
     */
    public $canUnlockCard;

    /**
     * 
     *
     * @var bool $canReplaceCard 
     */
    public $canReplaceCard;

    /**
     * 
     *
     * @var bool $canSearchCustomer 
     */
    public $canSearchCustomer;

    /**
     * 
     *
     * @var bool $canExchangePrizes 
     */
    public $canExchangePrizes;

    /**
     * 
     *
     * @var bool $canDeliverPrizes 
     */
    public $canDeliverPrizes;

    /**
     * 
     *
     * @var bool $canExtendExpirationDate 
     */
    public $canExtendExpirationDate;

    /**
     * 
     *
     * @var bool $canModifyCategory 
     */
    public $canModifyCategory;

    /**
     * 
     *
     * @var bool $canDeliverStatusPoints 
     */
    public $canDeliverStatusPoints;

    /**
     * 
     *
     * @var bool $canRequestPoints 
     */
    public $canRequestPoints;

    /**
     * 
     *
     * @var bool $canCancelTransaction 
     */
    public $canCancelTransaction;

    /**
     * 
     *
     * @var bool $canTransferPoints 
     */
    public $canTransferPoints;

    /**
     * 
     *
     * @var bool $canCancelOtherTerminalTransactions 
     */
    public $canCancelOtherTerminalTransactions;

    /**
     * 
     *
     * @var bool $canCancelTransactionById 
     */
    public $canCancelTransactionById;

    /**
     * 
     *
     * @var bool $canLockCustomers 
     */
    public $canLockCustomers;

    /**
     * 
     *
     * @var bool $canUnlockCustomers 
     */
    public $canUnlockCustomers;

    /**
     * 
     *
     * @var bool $canModifyCustomer 
     */
    public $canModifyCustomer;

    /**
     * 
     *
     * @var bool $canDoCheckIn 
     */
    public $canDoCheckIn;

    /**
     * 
     *
     * @var bool $canDoCheckOut 
     */
    public $canDoCheckOut;
}
