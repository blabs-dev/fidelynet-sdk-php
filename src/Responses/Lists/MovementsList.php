<?php
/*
 * Copyright (c) B@Labs srl 2021.
 * @category Tests
 * @package  Blabs/FidelyNet
 * @author   Salvo Bonanno <s.bonanno@blabs.it>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://www.blabs.it
 *
 */

namespace Blabs\FidelyNet\Responses\Lists;

use Blabs\FidelyNet\Responses\DataModels\MovementData;
use Blabs\FidelyNet\Responses\DataModels\PaginationData;
use Spatie\DataTransferObject\DataTransferObject;

final class MovementsList extends DataTransferObject
{
    /** @var MovementData[] */
    public array $movements;

    /** @var PaginationData */
    public PaginationData $pagination;
}
