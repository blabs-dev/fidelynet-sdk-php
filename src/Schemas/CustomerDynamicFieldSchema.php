<?php

namespace Blabs\FidelyNet\Schemas;

use Spatie\DataTransferObject\DataTransferObject;

class CustomerDynamicFieldSchema extends DataTransferObject
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $value;
}
