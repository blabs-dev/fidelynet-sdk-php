<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

class MovementShopData extends DataTransferObject
{
    public int $id;
    public string $name;
    public int $campaignIDByDefault;
    public int $currencyID;
    public string $currencySymbol;
    public mixed $behaviorFlags;
}
