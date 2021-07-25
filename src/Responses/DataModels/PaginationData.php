<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

class PaginationData extends DataTransferObject
{
    /** @var int */
    public $InitLimit;

    /** @var int */
    public $rowCount;

    /** @var mixed */
    public $orders;

    /** @var int */
    public $recordsTotal;

    /** @var int */
    public $actualPage;

    /** @var int */
    public $totalPages;
}
