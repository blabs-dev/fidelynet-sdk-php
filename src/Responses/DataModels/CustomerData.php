<?php
/*
 * Copyright (c) B@Labs srl 2021.
 * @category Tests
 * @package  Blabs/FidelyNet
 * @author   Salvo Bonanno <s.bonanno@blabs.it>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://www.blabs.it
 *
 */

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class CustomerData extends DataTransferObject
{
    // region IDENTIFIERS, STATUSES AND OTHER INFORMATIONS

    /** @var int|null */
    public ?int $id;

    /** @var int|null */
    public ?int $category;

    /** @var int|null */
    public ?int $status;

    /** @var string */
    public string $userName;

    /** @var string|null */
    public ?string $pincode;

    /** @var string|null */
    public ?string $expiration;

    /** @var mixed */
    public mixed $flags;

    /** @var mixed */
    public mixed $mlmCustomerId;

    /** @var int|null */
    public ?int $customer_area_status;

    /** @var int|null */
    public ?int $foreignId;

    /** @var int|null */
    public ?int $totalMlmChildren;

    /** @var string|null */
    public ?string $lastMovement;

    /** @var string|null */
    public ?string $notes;

    // endregion

    // region CARD DATA

    // region GENERAL

    /** @var int|null */
    public ?int $campaign;

    /** @var int|null */
    public ?int $card;

    /** @var int|null */
    public ?int $cardType;

    /** @var int|null */
    public ?int $fidelyCode;

    /** @var int|null */
    public ?int $rechargesCard;

    /** @var int|null */
    public ?int $usesCard;

    // endregion

    // region BALANCE

    /** @var int|null */
    public ?int $balance_points;

    /** @var int|null */
    public ?int $balance_credits;

    /** @var int|null */
    public ?int $balance_gift_credits;

    /** @var int|null */
    public ?int $balance_status_points;

    // endregion

    // region POINTS

    /** @var int|null */
    public ?int $pointsCharged;

    /** @var int|null */
    public ?int $pointsChargedCount;

    /** @var int|null */
    public ?int $pointsUsed;

    /** @var int|null */
    public ?int $pointsUsedCount;

    /** @var int|null */
    public ?int $pointsStatusCharged;

    /** @var int|null */
    public ?int $pointsStatusUsed;

    /** @var int|null */
    public ?int $pointsMLMCharged;

    /** @var int|null */
    public ?int $pointsMLMUsed;

    /** @var int|null */
    public ?int $pointsToExpire;

    /** @var int|null */
    public ?int $expiredPoints;

    /** @var int|null */
    public ?int $totalManualDischargedPoints;

    /** @var int|null */
    public ?int $totalDischargedPointsInSale;

    /** @var int|null */
    public ?int $totalDischargedPointsInExchanged;

    /** @var int|null */
    public ?int $totalDischargedPointsInTransfer;

    // endregion

    // region CREDITS

    /** @var int|null */
    public ?int $creditsCharged;

    /** @var int|null */
    public ?int $creditsUsed;

    /** @var int|null */
    public ?int $creditsGiftCharged;

    /** @var int|null */
    public ?int $creditsGiftUsed;

    // endregion

    // region MONEY

    /** @var int|null */
    public ?int $totalMoneyInSale;

    /** @var int|null */
    public ?int $paidMoneyInSale;

    // endregion

    // region PRIZES

    /** @var int|null */
    public ?int $totalExchangedPrizes;

    // endregion

    // endregion

    // region PERSONAL DATA

    /** @var string */
    public string $name;

    /** @var string */
    public string $surname;

    /** @var string|null */
    public ?string $gender;

    /** @var mixed */
    public mixed $privacy;

    /** @var int|null */
    public ?int $languageId;

    /**
     * @var string|null
     */
    public ?string $identityCard;
    /**
     * @var string|null
     */
    public ?string $birthdate;
    /**
     * @var string|null
     */

    // endregion

    // region CONTACTS, ADDRESS AND SOCIAL ACCOUNTS

    // region CONTACTS

    /** @var string */
    public string $mailContactData;

    /** @var string|null */
    public ?string $mobileContactData;

    /**
     * @var string|null
     */
    public ?string $telephoneContactData;
    /**
     * @var string|null
     */
    public ?string $faxContactData;

    // endregion

    // region ADDRESS

    /** @var string|null */
    public ?string $address;

    /**
     * @var string|null
     */
    public ?string $addressNumber;
    /**
     * @var string|null
     */
    public ?string $addressPrefix;

    /** @var string|null */
    public ?string $zip;

    /** @var int */
    public int $country;

    /** @var int|null */
    public ?int $geo_lat;

    /** @var int|null */
    public ?int $geo_long;

    /** @var int */
    public int $geoLevel1;

    /** @var int */
    public int $geoLevel2;

    /** @var int */
    public int $geoLevel3;

    /** @var int */
    public int $geoLevel4;

    /** @var int */
    public int $geoLevel5;

    /** @var int|null */
    public ?int $zoneId;

    //endregion

    // region SOCIAL ACCOUNTS

    /**
     * @var string|null
     */
    public ?string $facebookId;
    /**
     * @var string|null
     */
    public ?string $twitterId;
    /**
     * @var string|null
     */
    public ?string $instagramId;
    /**
     * @var string|null
     */
    public ?string $youtubeId;

    // endregion

    // endregion

    // region PARENT CUSTOMER

    /** @var int|null */
    public ?int $parentCustomerId;

    /** @var int|null */
    public ?int $percentajePointsParentCustomer;

    /** @var int|null */
    public ?int $percentajeCreditsParentCustomer;

    // endregion
}
