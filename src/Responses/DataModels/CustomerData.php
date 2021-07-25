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
    /** @var int $id */
    public $id;

    /** @var int $campaign */
    public $campaign;

    /** @var int $card */
    public $card;

    /** @var int $fidelyCode */
    public $fidelyCode;

    /** @var int $category */
    public $category;

    /** @var int $status */
    public $status;

    /** @var string $name */
    public $name;

    /** @var string $surname */
    public $surname;

    /** @var string $gender */
    public $gender;

    /** @var string $userName */
    public $userName;

    /** @var string $pincode */
    public $pincode;

    /** @var string $expiration */
    public $expiration;

    /** @var mixed $flags */
    public $flags;

    /** @var mixed $privacy */
    public $privacy;

    /** @var int $cardType */
    public $cardType;

    /** @var int $languageId */
    public $languageId;

    /** @var int $pointsCharged */
    public $pointsCharged;

    /** @var int $pointsChargedCount */
    public $pointsChargedCount;

    /** @var int $pointsUsed */
    public $pointsUsed;

    /** @var int $pointsUsedCount */
    public $pointsUsedCount;

    /** @var int $pointsStatusCharged */
    public $pointsStatusCharged;

    /** @var int $pointsStatusUsed */
    public $pointsStatusUsed;

    /** @var int $pointsMLMCharged */
    public $pointsMLMCharged;

    /** @var int $pointsMLMUsed */
    public $pointsMLMUsed;

    /** @var int $creditsCharged */
    public $creditsCharged;

    /** @var int $creditsUsed */
    public $creditsUsed;

    /** @var int $creditsGiftCharged */
    public $creditsGiftCharged;

    /** @var int $creditsGiftUsed */
    public $creditsGiftUsed;

    /** @var int $rechargesCard */
    public $rechargesCard;

    /** @var int $usesCard */
    public $usesCard;

    /** @var string $mailContactData */
    public $mailContactData;

    /** @var string $mobileContactData */
    public $mobileContactData;

    /** @var string $address */
    public $address;

    /** @var string $zip */
    public $zip;

    /** @var int $parentCustomerId */
    public $parentCustomerId;

    /** @var int $percentajePointsParentCustomer */
    public $percentajePointsParentCustomer;

    /** @var int $percentajeCreditsParentCustomer */
    public $percentajeCreditsParentCustomer;

    /** @var mixed $mlmCustomerId */
    public $mlmCustomerId;

    /** @var int $geo_lat */
    public $geo_lat;

    /** @var int $geo_long */
    public $geo_long;

    /** @var int $country */
    public $country;

    /** @var int $geoLevel1 */
    public $geoLevel1;

    /** @var int $geoLevel2 */
    public $geoLevel2;

    /** @var int $geoLevel3 */
    public $geoLevel3;

    /** @var int $geoLevel4 */
    public $geoLevel4;

    /** @var int $geoLevel5 */
    public $geoLevel5;

    /** @var int $balance_points */
    public $balance_points;

    /** @var int $balance_credits */
    public $balance_credits;

    /** @var int $balance_gift_credits */
    public $balance_gift_credits;

    /** @var int $balance_status_points */
    public $balance_status_points;

    /** @var int $pointsToExpire */
    public $pointsToExpire;

    /** @var int $expiredPoints */
    public $expiredPoints;

    /** @var int $zoneId */
    public $zoneId;

    /** @var int $customer_area_status */
    public $customer_area_status;

    /** @var int $totalExchangedPrizes */
    public $totalExchangedPrizes;

    /** @var int $totalMoneyInSale */
    public $totalMoneyInSale;

    /** @var int $paidMoneyInSale */
    public $paidMoneyInSale;

    /** @var int $totalMlmChildren */
    public $totalMlmChildren;

    /** @var int $totalManualDischargedPoints */
    public $totalManualDischargedPoints;

    /** @var int $totalDischargedPointsInSale */
    public $totalDischargedPointsInSale;

    /** @var int $totalDischargedPointsInExchanged */
    public $totalDischargedPointsInExchanged;

    /** @var int $totalDischargedPointsInTransfer */
    public $totalDischargedPointsInTransfer;
}