<?php

namespace Blabs\FidelyNet\Requests;

use Blabs\FidelyNet\Schemas\CustomerDynamicFieldSchema;
use Spatie\DataTransferObject\DataTransferObject;

class CustomerRequestData extends DataTransferObject
{
    /** @var string|null */
    public ?string $campaignid;

    /** @var string|null */
    public ?string $registrationshopid;

    /** @var string|null */
    public ?string $dni;

    /** @var string|null */
    public ?string $email;

    /** @var string|null */
    public ?string $name;

    /** @var string|null */
    public ?string $password;

    /** @var string|null */
    public ?string $surname;

    /** @var string|null */
    public ?string $gender;

    /** @var string|null */
    public ?string $birthdate;

    /** @var string|null */
    public ?string $notes;

    /** @var string|null */
    public ?string $username;

    /** @var string|null */
    public ?string $flags;

    /** @var bool|null */
    public ?bool $usedforpromotions;

    /** @var bool|null */
    public ?bool $usedforstatistics;

    /** @var bool|null */
    public ?bool $usedbyothers;

    /** @var string|null */
    public ?string $cangetcurrentlocation;

    /** @var string|null */
    public ?string $cancomunicaverification;

    /** @var string|null */
    public ?string $mobile;

    /** @var string|null */
    public ?string $telephone;

    /** @var string|null */
    public ?string $fax;

    /** @var string|null */
    public ?string $address;

    /** @var string|null */
    public ?string $addressnumber;

    /** @var string|null */
    public ?string $addressprefix;

    /** @var string|null */
    public ?string $zipcode;

    /** @var string|null */
    public ?string $geo_lat;

    /** @var string|null */
    public ?string $geo_long;

    /** @var string|null */
    public ?string $country;

    /** @var string|null */
    public ?string $geo_level_1;

    /** @var string|null */
    public ?string $geo_level_2;

    /** @var string|null */
    public ?string $geo_level_3;

    /** @var string|null */
    public ?string $geo_level_4;

    /** @var string|null */
    public ?string $geo_level_5;

    /** @var string|null */
    public ?string $facebookid;

    /** @var CustomerDynamicFieldSchema[]|null */
    public ?array $customerdynamicfields;

    /** @var string|null */
    public ?string $twitterid;

    /** @var string|null */
    public ?string $youtubeid;

    /** @var string|null */
    public ?string $instagramid;

    /** @var string|null */
    public ?string $interestareas;

    /** @var string|null */
    public ?string $invitecustomerid;
}
