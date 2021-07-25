<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class OperatorData extends DataTransferObject
{
    /**
     * 
     *
     * @var int $id 
     */
    public $id;

    /**
     * 
     *
     * @var string $username 
     */
    public $username;

    /**
     * 
     *
     * @var string $name 
     */
    public $name;

    /**
     * 
     *
     * @var string $surname 
     */
    public $surname;

    /**
     * 
     *
     * @var int $language 
     */
    public $language;

    /**
     * 
     *
     * @var \Blabs\FidelyNet\Responses\DataModels\OperatorFlagsData $flags 
     */
    public $flags;

    public $profile;
}
