<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class OperatorFlagsData extends DataTransferObject
{
    /**
     * @var int
     */
    public $flags;

    /**
     * @var bool
     */
    public $isEnabled;
}
