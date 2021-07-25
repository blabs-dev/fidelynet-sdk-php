<?php


namespace Blabs\FidelyNet\Responses\ResponseData;


use Spatie\DataTransferObject\DataTransferObject;

final class LoginResponseData extends DataTransferObject
{
    /**
     * 
     *
     * @var int|string|null $answerCode 
     */
    public $answerCode;

    /**
     * 
     *
     * @var string|null $sessionID 
     */
    public $sessionID;

    /**
     * 
     *
     * @var \Blabs\FidelyNet\Responses\DataModels\OperatorData|null $operator  
     */
    public $operator;
}
