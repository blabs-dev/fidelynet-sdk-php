<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class TerminalData extends DataTransferObject
{
    /**
     * 
     *
     * @var int $terminalId 
     */
    public $terminalId;

    /**
     * 
     *
     * @var mixed $behaviorFlags 
     */
    public $behaviorFlags;

    /**
     * 
     *
     * @var mixed $informativeFlags 
     */
    public $informativeFlags;
}
