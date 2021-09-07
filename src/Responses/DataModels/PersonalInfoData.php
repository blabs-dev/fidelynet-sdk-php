<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class PersonalInfoData extends DataTransferObject
{
    // region IDENTIFIERS
    /**
     * @var int|null
     */
    public ?int $foreignId;
    // endregion

    // region PERSONAL DATA
    /**
     * @var string|null
     */
    public ?string $identityCard;
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
    public ?string $userName;

    /**
     * @var string|null
     */
    public ?string $interestAreas;
    // endregion

    // region PRIVACY AND OTHER FLAGS
    /**
     * @var PrivacyData|null
     */
    public ?PrivacyData $privacy;
    // endregion

    // region CONTACT DATA
    /**
     * @var string|null
     */
    public ?string $mailContactData;
    /**
     * @var string|null
     */
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
    /**
     * @var string|null
     */
    public ?string $address;
    /**
     * @var string|null
     */
    public ?string $addressNumber;
    /**
     * @var string|null
     */
    public ?string $addressPrefix;
    /**
     * @var string|null
     */
    public ?string $zip;
    /**
     * @var int|string|null
     */
    public int|string|null $country;
    /**
     * @var float|string|null
     */
    public float|string|null $geo_lat;
    /**
     * @var float|string|null
     */
    public float|string|null $geo_long;
    /**
     * @var int|string|null
     */
    public int|string|null $geoLevel1;
    /**
     * @var int|string|null
     */
    public int|string|null $geoLevel2;
    /**
     * @var int|string|null
     */
    public int|string|null $geoLevel3;
    /**
     * @var int|string|null
     */
    public int|string|null $geoLevel4;
    /**
     * @var int|string|null
     */
    public int|string|null $geoLevel5;
    // endregion

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
}
