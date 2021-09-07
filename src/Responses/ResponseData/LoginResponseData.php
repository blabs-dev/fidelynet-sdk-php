<?php

namespace Blabs\FidelyNet\Responses\ResponseData;

use Blabs\FidelyNet\Responses\DataModels\OperatorData;
use Spatie\DataTransferObject\DataTransferObject;

final class LoginResponseData extends DataTransferObject
{
    /**
     * @var int|string|null
     */
    public int|string|null $answerCode;

    /**
     * @var string|null
     */
    public ?string $sessionID;

    /**
     * @var OperatorData|null
     */
    public ?OperatorData $operator;
}
