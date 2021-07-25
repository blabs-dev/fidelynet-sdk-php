<?php


namespace Blabs\FidelyNet\Requests;


use Blabs\FidelyNet\Schemas\CustomerDynamicFieldSchema;
use Spatie\DataTransferObject\DataTransferObject;

class CustomerRequestData extends DataTransferObject
{
    /** @var string|null */
    public $campaignid;

    /** @var string|null */
    public $registrationshopid;

    /** @var string|null */
    public $dni;

    /** @var string|null */
    public $email;

    /** @var string|null */
    public $name;

    /** @var string|null */
    public $password;

    /** @var string|null */
    public $surname;

    /** @var string|null */
    public $gender;

    /** @var string|null */
    public $birthdate;

    /** @var string|null */
    public $notes;

    /** @var string|null */
    public $username;

    /** @var string|null */
    public $flags;

    /** @var bool|null */
    public $usedforpromotions;

    /** @var bool|null */
    public $usedforstatistics;

    /** @var bool|null */
    public $usedbyothers;

    /** @var string|null */
    public $cangetcurrentlocation;

    /** @var string|null */
    public $cancomunicaverification;

    /** @var string|null */
    public $mobile;

    /** @var string|null */
    public $telephone;

    /** @var string|null */
    public $fax;

    /** @var string|null */
    public $address;

    /** @var string|null */
    public $addressnumber;

    /** @var string|null */
    public $addressprefix;

    /** @var string|null */
    public $zipcode;

    /** @var string|null */
    public $geo_lat;

    /** @var string|null */
    public $geo_long;

    /** @var string|null */
    public $country;

    /** @var string|null */
    public $geo_level_1;

    /** @var string|null */
    public $geo_level_2;

    /** @var string|null */
    public $geo_level_3;

    /** @var string|null */
    public $geo_level_4;

    /** @var string|null */
    public $geo_level_5;

    /** @var string|null */
    public $facebookid;

    /** @var CustomerDynamicFieldSchema[]|null */
    public $customerdynamicfields;

    /** @var string|null */
    public $twitterid;

    /** @var string|null */
    public $youtubeid;

    /** @var string|null */
    public $instagramid;

    /** @var string|null */
    public $interestareas;

    /** @var string|null */
    public $invitecustomerid;
}