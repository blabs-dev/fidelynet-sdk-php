<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class TerminalData extends DataTransferObject
{
    /**
     * @var int
     */
    public int $terminalId;

    /**
     * @var mixed
     */
    public mixed $behaviorFlags;

    /**
     * @var mixed
     */
    public mixed $informativeFlags;
}
