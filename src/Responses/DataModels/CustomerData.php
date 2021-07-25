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
    /** @var int */
    public $id;

    /** @var int */
    public $campaign;

    /** @var int */
    public $card;

    /** @var int */
    public $fidelyCode;

    /** @var int */
    public $category;

    /** @var int */
    public $status;

    /** @var string */
    public $name;

    /** @var string */
    public $surname;

    /** @var string|null */
    public $gender;

    /** @var string */
    public $userName;

    /** @var string */
    public $pincode;

    /** @var string */
    public $expiration;

    /** @var mixed */
    public $flags;

    /** @var mixed */
    public $privacy;

    /** @var int */
    public $cardType;

    /** @var int */
    public $languageId;

    /** @var int */
    public $pointsCharged;

    /** @var int */
    public $pointsChargedCount;

    /** @var int */
    public $pointsUsed;

    /** @var int */
    public $pointsUsedCount;

    /** @var int */
    public $pointsStatusCharged;

    /** @var int */
    public $pointsStatusUsed;

    /** @var int */
    public $pointsMLMCharged;

    /** @var int */
    public $pointsMLMUsed;

    /** @var int */
    public $creditsCharged;

    /** @var int */
    public $creditsUsed;

    /** @var int */
    public $creditsGiftCharged;

    /** @var int */
    public $creditsGiftUsed;

    /** @var int */
    public $rechargesCard;

    /** @var int */
    public $usesCard;

    /** @var string */
    public $mailContactData;

    /** @var string|null */
    public $mobileContactData;

    /** @var string|null */
    public $address;

    /** @var string|null */
    public $zip;

    /** @var int */
    public $parentCustomerId;

    /** @var int */
    public $percentajePointsParentCustomer;

    /** @var int */
    public $percentajeCreditsParentCustomer;

    /** @var mixed */
    public $mlmCustomerId;

    /** @var int */
    public $geo_lat;

    /** @var int */
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

    /** @var int */
    public $balance_points;

    /** @var int */
    public $balance_credits;

    /** @var int */
    public $balance_gift_credits;

    /** @var int */
    public $balance_status_points;

    /** @var int */
    public $pointsToExpire;

    /** @var int */
    public $expiredPoints;

    /** @var int */
    public $zoneId;

    /** @var int */
    public $customer_area_status;

    /** @var int */
    public $totalExchangedPrizes;

    /** @var int */
    public $totalMoneyInSale;

    /** @var int */
    public $paidMoneyInSale;

    /** @var int */
    public $totalMlmChildren;

    /** @var int */
    public $totalManualDischargedPoints;

    /** @var int */
    public $totalDischargedPointsInSale;

    /** @var int */
    public $totalDischargedPointsInExchanged;

    /** @var int */
    public $totalDischargedPointsInTransfer;

    /** @var string|null */
    public $lastMovement;
}
