<?php

namespace Blabs\FidelyNet\Requests;

use Blabs\FidelyNet\Schemas\CustomerDynamicFieldSchema;
use Spatie\DataTransferObject\DataTransferObject;

class ModifyCustomerRequestData extends DataTransferObject
{
    // region IDENTIFIERS, STATUSES AND OTHER INFORMATIONS
    /**
     * @var int
     */
    public int $id;
    /**
     * @var int
     */
    public int $campaignid;
    /**
     * @var int|null
     */
    public ?int $card;
    /**
     * @var int|null
     */
    public ?int $fidelycode;
    /**
     * @var int|null
     */
    public ?int $parentcustomerid;
    /**
     * @var int|null
     */
    public ?int $mlmcustomerid;
    /**
     * @var int|null
     */
    public ?int $zoneid;
    /**
     * @var int|null
     */
    public ?int $zoneforeignid;
    /**
     * @var string|null
     */
    public ?string $customer_area_status;
    // endregion

    // region PERSONAL DATA
    /**
     * @var string|null
     */
    public ?string $identitycard;
    /**
     * @var string|null
     */
    public ?string $name;
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
    public ?string $notes;
    /**
     * @var string|null
     */
    public ?string $username;
    // endregion

    // region PRIVACY AND OTHER FLAGS
    /**
     * @var string|null
     */
    public ?string $flags;
    /**
     * @var bool|null
     */
    public ?bool $usedforpromotions;
    /**
     * @var bool|null
     */
    public ?bool $usedforstatistics;
    /**
     * @var bool|null
     */
    public ?bool $usedbyothers;
    /**
     * @var bool|null
     */
    public ?bool $cangetcurrentlocation;
    /**
     * @var bool|null
     */
    public ?bool $cancomunicaverification;
    // endregion

    // region CONTACT DATA
    /**
     * @var string|null
     */
    public ?string $mailcontactdata;
    /**
     * @var string|null
     */
    public ?string $mobilecontactdata;
    /**
     * @var string|null
     */
    public ?string $telephonecontactdata;
    /**
     * @var string|null
     */
    public ?string $faxcontactdata;
    // endregion

    // region ADDRESS
    /**
     * @var string|null
     */
    public ?string $address;
    /**
     * @var string|null
     */
    public ?string $addressnumber;
    /**
     * @var string|null
     */
    public ?string $addressprefix;
    /**
     * @var string|null
     */
    public ?string $zip;
    /**
     * @var string|null
     */
    public ?string $country;
    /**
     * @var string|null
     */
    public ?string $geolevel1;
    /**
     * @var string|null
     */
    public ?string $geolevel2;
    /**
     * @var string|null
     */
    public ?string $geolevel3;
    /**
     * @var string|null
     */
    public ?string $geolevel4;
    /**
     * @var string|null
     */
    public ?string $geolevel5;
    // endregion

    // region SOCIAL ACCOUNTS
    /**
     * @var string|null
     */
    public ?string $facebookid;
    // endregion

    // region DYNAMIC FIELDS AND PROFILATION FIELDS
    /**
     * @var array|null
     */
    public ?array $customerdynamicfields;
    /**
     * @var string|null
     */
    public ?string $interestareas;
    // endregion
}
