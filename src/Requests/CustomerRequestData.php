<?php

namespace Blabs\FidelyNet\Requests;

use Spatie\DataTransferObject\DataTransferObject;

class CustomerRequestData extends DataTransferObject
{
    /**
     * @var int|null
     */
    public ?int $campaignid;

    /**
     * @var int|null
     */
    public ?int $registrationshopid;

    /**
     * @var string|null
     */
    public ?string $dni;

    // region PERSONAL DATA

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $password;

    /**
     * @var string|null
     */
    public ?string $surname;

    /**
     * @var string|null
     */
    public ?string $gender;

    /**
     * @var string|null
     */
    public ?string $birthdate;

    /**
     * @var string|null
     */
    public ?string $username;

    /**
     * @var string|null
     */
    public ?string $notes;

    // endregion

    // region PRIVACY AND OTHER FLAGS

    /**
     * @var int|null
     */
    public ?int $flags;

    /**
     * @var bool|null
     */
    public ?bool $usedForPromotions;

    /**
     * @var bool|null
     */
    public ?bool $usedForStatistics;

    /**
     * @var bool|null
     */
    public ?bool $usedByOthers;

    /**
     * @var bool|null
     */
    public ?bool $canGetCurrentLocation;

    /**
     * @var bool|null
     */
    public ?bool $canComunicaVerification;

    // endregion

    // region CONTACTS

    /**
     * @var string|null
     */
    public ?string $email;

    /**
     * @var string|null
     */
    public ?string $mobile;

    /**
     * @var string|null
     */
    public ?string $telephone;

    /**
     * @var string|null
     */
    public ?string $fax;

    // endregion

    // region ADDRESS
    /**
     * @var string|null
     */
    public ?string $address;

    /** @var string|null */
    public ?string $addressnumber;

    /**
     * @var string|null
     */
    public ?string $addressprefix;

    /**
     * @var string|null
     */
    public ?string $zipcode;

    /**
     * @var int|null
     */
    public ?int $country;

    /**
     * @var mixed
     */
    public mixed $geo_lat;

    /**
     * @var mixed
     */
    public mixed $geo_long;

    /**
     * @var int|null
     */
    public ?int $geo_level_1;

    /**
     * @var int|null
     */
    public ?int $geo_level_2;

    /**
     * @var int|null
     */
    public ?int $geo_level_3;

    /**
     * @var int|null
     */
    public ?int $geo_level_4;

    /**
     * @var int|null
     */
    public ?int $geo_level_5;

    // endregion

    // region SOCIAL ACCOUNTS

    /**
     * @var string|null
     */
    public ?string $facebookid;

    /**
     * @var string|null
     */
    public ?string $twitterid;

    /**
     * @var string|null
     */
    public ?string $youtubeid;

    /**
     * @var string|null
     */
    public ?string $instagramid;

    // endregion

    // region OTHER FIELDS

    /**
     * @var string|null
     */
    public ?string $interestareas;

    /**
     * @var string|null
     */
    public ?int $invitecustomerid;

    // endregion
}
