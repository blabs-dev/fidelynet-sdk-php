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

use Spatie\DataTransferObject\DataTransferObject;

class MovementsList extends DataTransferObject
{
    /** @var \Blabs\FidelyNet\Responses\DataModels\MovementData[] */
    public $movements;

    /** @var \Blabs\FidelyNet\Responses\DataModels\PaginationData */
    public $pagination;
}
