<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class TerminalData extends DataTransferObject
{
    /**
     * @var int
     */
    public $terminalId;

    /**
     * @var mixed
     */
    public $behaviorFlags;

    /**
     * @var mixed
     */
    public $informativeFlags;
}
