<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class DynamicField extends DataTransferObject
{
    public int $id;
    public int $campaignID;
    public string $name;
    public int $order;
    public int $representation;
    public mixed $type;
}
