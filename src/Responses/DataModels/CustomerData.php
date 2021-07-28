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

    /** @var string|null */
    public ?string $id;

    /** @var string|null */
    public ?string $category;

    /** @var string|null */
    public ?string $status;

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

    /** @var string|null */
    public ?string $customer_area_status;

    /** @var string|null */
    public ?string $foreignId;

    /** @var string|null */
    public ?string $totalMlmChildren;

    /** @var string|null */
    public ?string $lastMovement;

    /** @var string|null */
    public ?string $notes;

    /** @var string|null */
    public ?string $interestAreas;

    // endregion

    // region CARD DATA

    // region GENERAL

    /** @var string|null */
    public ?string $campaign;

    /** @var string|null */
    public ?string $card;

    /** @var string|null */
    public ?string $cardType;

    /** @var string|null */
    public ?string $fidelyCode;

    /** @var string|null */
    public ?string $rechargesCard;

    /** @var string|null */
    public ?string $usesCard;

    // endregion

    // region BALANCE

    /** @var string|null */
    public ?string $balance_postrings;

    /** @var string|null */
    public ?string $balance_credits;

    /** @var string|null */
    public ?string $balance_gift_credits;

    /** @var string|null */
    public ?string $balance_status_postrings;

    // endregion

    // region POstringS

    /** @var string|null */
    public ?string $postringsCharged;

    /** @var string|null */
    public ?string $postringsChargedCount;

    /** @var string|null */
    public ?string $postringsUsed;

    /** @var string|null */
    public ?string $postringsUsedCount;

    /** @var string|null */
    public ?string $postringsStatusCharged;

    /** @var string|null */
    public ?string $postringsStatusUsed;

    /** @var string|null */
    public ?string $postringsMLMCharged;

    /** @var string|null */
    public ?string $postringsMLMUsed;

    /** @var string|null */
    public ?string $postringsToExpire;

    /** @var string|null */
    public ?string $expiredPostrings;

    /** @var string|null */
    public ?string $totalManualDischargedPostrings;

    /** @var string|null */
    public ?string $totalDischargedPostringsInSale;

    /** @var string|null */
    public ?string $totalDischargedPostringsInExchanged;

    /** @var string|null */
    public ?string $totalDischargedPostringsstringransfer;

    // endregion

    // region CREDITS

    /** @var string|null */
    public ?string $creditsCharged;

    /** @var string|null */
    public ?string $creditsUsed;

    /** @var string|null */
    public ?string $creditsGiftCharged;

    /** @var string|null */
    public ?string $creditsGiftUsed;

    // endregion

    // region MONEY

    /** @var string|null */
    public ?string $totalMoneyInSale;

    /** @var string|null */
    public ?string $paidMoneyInSale;

    // endregion

    // region PRIZES

    /** @var string|null */
    public ?string $totalExchangedPrizes;

    // endregion

    // endregion

    // region PERSONAL DATA

    /** @var string */
    public string $name;

    /** @var string */
    public string $surname;

    /** @var string|null */
    public ?string $gender;

    /** @var PrivacyData|null */
    public ?PrivacyData $privacy;

    /** @var string|null */
    public ?string $languageId;

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

    /** @var string */
    public string $country;

    /** @var string|null */
    public ?string $geo_lat;

    /** @var string|null */
    public ?string $geo_long;

    /** @var string */
    public string $geoLevel1;

    /** @var string */
    public string $geoLevel2;

    /** @var string */
    public string $geoLevel3;

    /** @var string */
    public string $geoLevel4;

    /** @var string */
    public string $geoLevel5;

    /** @var string|null */
    public ?string $zoneId;

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

    /** @var string|null */
    public ?string $parentCustomerId;

    /** @var string|null */
    public ?string $percentajePostringsParentCustomer;

    /** @var string|null */
    public ?string $percentajeCreditsParentCustomer;

    // endregion
}
