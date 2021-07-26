<?php

namespace Blabs\FidelyNet\Responses;

use Spatie\DataTransferObject\DataTransferObject;

final class ApiResponse extends DataTransferObject
{
    /**
     * @var int|string|null
     */
    public int | string | null $returncode;

    /**
     * @var mixed
     */
    public mixed $data;

    /**
     * @var mixed|null
     */
    public mixed $data2;

    /**
     * @var mixed|null
     */
    public mixed $data3;

    /**
     * @var mixed|null
     */
    public mixed $data4;

    /**
     * @var mixed|null
     */
    public mixed $data5;

    /**
     * @var string|null
     */
    public ?string $sessionid;

    /**
     * @var string|null
     */
    public ?string $ambiente;
}
