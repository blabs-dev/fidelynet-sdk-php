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
    public $id;
    /**
     * @var int
     */
    public $campaignid;
    /**
     * @var int|null
     */
    public $card;
    /**
     * @var int|null
     */
    public $fidelycode;
    /**
     * @var int|null
     */
    public $parentcustomerid;
    /**
     * @var int|null
     */
    public $mlmcustomerid;
    /**
     * @var int|null
     */
    public $zoneid;
    /**
     * @var int|null
     */
    public $zoneforeignid;
    /**
     * @var string|null
     */
    public $customer_area_status;
    // endregion

    // region PERSONAL DATA
    /**
     * @var string|null
     */
    public $identitycard;
    /**
     * @var string|null
     */
    public $name;
    /**
     * @var string|null
     */
    public $surname;
    /**
     * @var string|null
     */
    public $gender;
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
    public $username;
    // endregion

    // region PRIVACY AND OTHER FLAGS
    /**
     * @var string|null
     */
    public $flags;
    /**
     * @var bool|null
     */
    public $usedforpromotions;
    /**
     * @var bool|null
     */
    public $usedforstatistics;
    /**
     * @var bool|null
     */
    public $usedbyothers;
    /**
     * @var bool|null
     */
    public $cangetcurrentlocation;
    /**
     * @var bool|null
     */
    public $cancomunicaverification;
    // endregion

    // region CONTACT DATA
    /**
     * @var string|null
     */
    public $mailcontactdata;
    /**
     * @var string|null
     */
    public $mobilecontactdata;
    /**
     * @var string|null
     */
    public $telephonecontactdata;
    /**
     * @var string|null
     */
    public $faxcontactdata;
    // endregion

    // region ADDRESS
    /**
     * @var string|null
     */
    public $address;
    /**
     * @var string|null
     */
    public $addressnumber;
    /**
     * @var string|null
     */
    public $addressprefix;
    /**
     * @var string|null
     */
    public $zip;
    /**
     * @var string|null
     */
    public $country;
    /**
     * @var string|null
     */
    public $geolevel1;
    /**
     * @var string|null
     */
    public $geolevel2;
    /**
     * @var string|null
     */
    public $geolevel3;
    /**
     * @var string|null
     */
    public $geolevel4;
    /**
     * @var string|null
     */
    public $geolevel5;
    // endregion

    // region SOCIAL ACCOUNTS
    /**
     * @var string|null
     */
    public $facebookid;
    // endregion

    // region DYNAMIC FIELDS AND PROFILATION FIELDS
    /**
     * @var array|null
     */
    public $customerdynamicfields;
    /**
     * @var string|null
     */
    public $interestareas;
    // endregion
}