<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class OperatorFlagsData extends DataTransferObject
{
    /**
     * @var int
     */
    public int $flags;

    /**
     * @var bool
     */
    public bool $isEnabled;
}
