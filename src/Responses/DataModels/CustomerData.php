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

class CustomerData extends DataTransferObject
{
    /** @var int|null */
    public $id;

    /** @var int|null */
    public $campaign;

    /** @var int|null */
    public $card;

    /** @var int|null */
    public $fidelyCode;

    /** @var int|null */
    public $category;

    /** @var int|null */
    public $status;

    /** @var string */
    public $name;

    /** @var string */
    public $surname;

    /** @var string|null */
    public $gender;

    /** @var string */
    public $userName;

    /** @var string|null */
    public $pincode;

    /** @var string|null */
    public $expiration;

    /** @var mixed */
    public $flags;

    /** @var mixed */
    public $privacy;

    /** @var int|null */
    public $cardType;

    /** @var int|null */
    public $languageId;

    /** @var int|null */
    public $pointsCharged;

    /** @var int|null */
    public $pointsChargedCount;

    /** @var int|null */
    public $pointsUsed;

    /** @var int|null */
    public $pointsUsedCount;

    /** @var int|null */
    public $pointsStatusCharged;

    /** @var int|null */
    public $pointsStatusUsed;

    /** @var int|null */
    public $pointsMLMCharged;

    /** @var int|null */
    public $pointsMLMUsed;

    /** @var int|null */
    public $creditsCharged;

    /** @var int|null */
    public $creditsUsed;

    /** @var int|null */
    public $creditsGiftCharged;

    /** @var int|null */
    public $creditsGiftUsed;

    /** @var int|null */
    public $rechargesCard;

    /** @var int|null */
    public $usesCard;

    /** @var string */
    public $mailContactData;

    /** @var string|null */
    public $mobileContactData;

    /** @var string|null */
    public $address;

    /** @var string|null */
    public $zip;

    /** @var int|null */
    public $parentCustomerId;

    /** @var int|null */
    public $percentajePointsParentCustomer;

    /** @var int|null */
    public $percentajeCreditsParentCustomer;

    /** @var mixed */
    public $mlmCustomerId;

    /** @var int|null */
    public $geo_lat;

    /** @var int|null */
    public $geo_long;

    /** @var int */
    public $country;

    /** @var int */
    public $geoLevel1;

    /** @var int */
    public $geoLevel2;

    /** @var int */
    public $geoLevel3;

    /** @var int */
    public $geoLevel4;

    /** @var int */
    public $geoLevel5;

    /** @var int|null */
    public $balance_points;

    /** @var int|null */
    public $balance_credits;

    /** @var int|null */
    public $balance_gift_credits;

    /** @var int|null */
    public $balance_status_points;

    /** @var int|null */
    public $pointsToExpire;

    /** @var int|null */
    public $expiredPoints;

    /** @var int|null */
    public $zoneId;

    /** @var int|null */
    public $customer_area_status;

    /** @var int|null */
    public $totalExchangedPrizes;

    /** @var int|null */
    public $totalMoneyInSale;

    /** @var int|null */
    public $paidMoneyInSale;

    /** @var int|null */
    public $totalMlmChildren;

    /** @var int|null */
    public $totalManualDischargedPoints;

    /** @var int|null */
    public $totalDischargedPointsInSale;

    /** @var int|null */
    public $totalDischargedPointsInExchanged;

    /** @var int|null */
    public $totalDischargedPointsInTransfer;

    /** @var string|null */
    public $lastMovement;

    /**
     * @var int|null
     */
    public $foreignId;
    /**
     * @var string|null
     */
    public $identityCard;
    /**
     * @var string|null
     */
    public $birthdate;
    /**
     * @var string|null
     */
    public $notes;
    /**
     * @var string|null
     */
    public $telephoneContactData;
    /**
     * @var string|null
     */
    public $faxContactData;
    /**
     * @var string|null
     */
    public $addressNumber;
    /**
     * @var string|null
     */
    public $addressPrefix;
    /**
     * @var string|null
     */
    public $facebookId;
    /**
     * @var string|null
     */
    public $twitterId;
    /**
     * @var string|null
     */
    public $instagramId;
    /**
     * @var string|null
     */
    public $youtubeId;

}
