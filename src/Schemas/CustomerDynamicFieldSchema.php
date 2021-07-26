<?php

namespace Blabs\FidelyNet\Schemas;

use Spatie\DataTransferObject\DataTransferObject;

class CustomerDynamicFieldSchema extends DataTransferObject
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $value;
}
