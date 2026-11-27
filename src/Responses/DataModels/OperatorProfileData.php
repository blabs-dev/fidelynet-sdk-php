<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use Spatie\DataTransferObject\DataTransferObject;

final class OperatorProfileData extends DataTransferObject
{
    /**
     * Builds the profile from the raw `operator.profile` block of a login reply.
     *
     * The block is not validated by the service: a missing permission is read
     * as `false` (and `rights` as 0), so a partial profile never grants more
     * than it says. Returns null when there is no profile at all.
     *
     * @param mixed $profile
     *
     * @return self|null
     */
    public static function fromLoginProfile(mixed $profile): ?self
    {
        if ($profile instanceof self) {
            return $profile;
        }

        if (is_object($profile)) {
            $profile = (array) $profile;
        }

        if (!is_array($profile) || $profile === []) {
            return null;
        }

        $values = [];

        foreach ((new ReflectionClass(self::class))->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $type = $property->getType();
            $name = $property->getName();
            $raw = $profile[$name] ?? null;

            $values[$name] = ($type instanceof ReflectionNamedType && $type->getName() === 'int')
                ? (is_numeric($raw) ? (int) $raw : 0)
                : filter_var($raw, FILTER_VALIDATE_BOOLEAN);
        }

        return new self($values);
    }

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
