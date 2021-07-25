<?php

namespace Blabs\FidelyNet\Responses\ResponseData;

use Spatie\DataTransferObject\DataTransferObject;

final class LoginResponseData extends DataTransferObject
{
    /**
     * @var int|string|null
     */
    public $answerCode;

    /**
     * @var string|null
     */
    public $sessionID;

    /**
     * @var \Blabs\FidelyNet\Responses\DataModels\OperatorData|null
     */
    public $operator;
}
