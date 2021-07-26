<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class OperatorData extends DataTransferObject
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $username;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $surname;

    /**
     * @var int
     */
    public int $language;

    /**
     * @var mixed
     */
    public mixed $flags;

    /**
     * @var mixed
     */
    public mixed $profile;
}
