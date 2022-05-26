<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

class ShopAndNetworksData extends DataTransferObject
{
    public mixed $networks;
    public mixed $shops;
}