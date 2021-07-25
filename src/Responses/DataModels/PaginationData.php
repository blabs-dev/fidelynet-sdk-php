<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

class PaginationData extends DataTransferObject
{
    /** @var int $InitLimit */
    public $InitLimit;

    /** @var int $rowCount */
    public $rowCount;

    /** @var mixed $orders */
    public $orders;

    /** @var int $recordsTotal */
    public $recordsTotal;

    /** @var int $actualPage */
    public $actualPage;

    /** @var int $totalPages */
    public $totalPages;
}
