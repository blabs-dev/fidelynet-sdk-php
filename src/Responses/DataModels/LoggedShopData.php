<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

class LoggedShopData extends DataTransferObject
{
    public int $id;
    public string $name;
    public ?string $logoSwUrl;
    public ?string $bannerSwUrl;
    public ?string $logoPosUrl;
    public ?int $campaignIdByDefault;
    public ?int $currencyId;
    public ?string $currencySymbol;
    public mixed $behaviorFlags;
    public ?string $addressPrefix;
    public ?int $country;
    public ?int $geoLevel1;
    public ?int $geoLevel2;
    public ?int $geoLevel3;
    public ?int $geoLevel4;
    public ?int $geoLevel5;
    public ?string $address;
    public ?float $geoLat;
    public ?float $geoLong;
    public ?string $addressNumber;
    public ?string $zip;
    public mixed $flags;
}
