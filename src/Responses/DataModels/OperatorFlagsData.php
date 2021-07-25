<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class OperatorFlagsData extends DataTransferObject
{
    /**
     * 
     *
     * @var int $flags 
     */
    public $flags;

    /**
     * 
     *
     * @var bool $isEnabled 
     */
    public $isEnabled;
}
