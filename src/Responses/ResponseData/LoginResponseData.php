<?php

namespace Blabs\FidelyNet\Responses\ResponseData;

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
     * @var \Blabs\FidelyNet\Responses\DataModels\OperatorData|null
     */
    public $operator;
}
