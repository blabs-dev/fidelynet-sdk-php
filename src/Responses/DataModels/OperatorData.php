<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class OperatorData extends DataTransferObject
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $surname;

    /**
     * @var int
     */
    public $language;

    /**
     * @var \Blabs\FidelyNet\Responses\DataModels\OperatorFlagsData
     */
    public $flags;

    public $profile;
}
