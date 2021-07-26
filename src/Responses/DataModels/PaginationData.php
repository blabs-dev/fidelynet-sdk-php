<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class PaginationData extends DataTransferObject
{
    /** @var int */
    public int $InitLimit;

    /** @var int */
    public int $rowCount;

    /** @var mixed */
    public mixed $orders;

    /** @var int */
    public int $recordsTotal;

    /** @var int */
    public int $actualPage;

    /** @var int */
    public int $totalPages;
}
