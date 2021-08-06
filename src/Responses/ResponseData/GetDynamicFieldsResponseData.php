<?php

namespace Blabs\FidelyNet\Responses\ResponseData;

use Blabs\FidelyNet\Responses\DataModels\DynamicField;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class GetDynamicFieldsResponseData extends DataTransferObject
{
    /** @var DynamicField[] */
    #[CastWith(ArrayCaster::class, itemType: DynamicField::class)]
    public array $dynamicFields;
}
