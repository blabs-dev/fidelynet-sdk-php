<?php


namespace Blabs\FidelyNet\Responses\DataModels;


use Spatie\DataTransferObject\DataTransferObject;

class PersonalInfoData extends DataTransferObject
{
    /**
     * @var int
     */
    public int $foreignId;
    /**
     * @var string
     */
    public string $identityCard;
    /**
     * @var string
     */
    public string $name;
    /**
     * @var string
     */
    public string $surname;
    /**
     * @var string
     */
    public string $gender;
    /**
     * @var string
     */
    public string $birthdate;
    /**
     * @var string
     */
    public string $notes;
    /**
     * @var string
     */
    public string $userName;
    /**
     * @var PrivacyData
     */
    public PrivacyData $privacy;

    /**
     * @var string
     */
    public string $mailContactData;
    /**
     * @var string
     */
    public string $mobileContactData;
    /**
     * @var string
     */
    public string $telephoneContactData;
    /**
     * @var string
     */
    public string $faxContactData;

    /**
     * @var string
     */
    public string $address;
    /**
     * @var string
     */
    public string $addressNumber;
    /**
     * @var string
     */
    public string $addressPrefix;
    /**
     * @var string
     */
    public string $zip;
    /**
     * @var int
     */
    public int $country;
    /**
     * @var int
     */
    public int $geoLevel1;
    /**
     * @var int
     */
    public int $geoLevel2;
    /**
     * @var int
     */
    public int $geoLevel3;
    /**
     * @var int
     */
    public int $geoLevel4;
    /**
     * @var int
     */
    public int $geoLevel5;

    /**
     * @var string
     */
    public string $facebookId;
    /**
     * @var string
     */
    public string $twitterId;
    /**
     * @var string
     */
    public string $instagramId;
    /**
     * @var string
     */
    public string $youtubeId;
}