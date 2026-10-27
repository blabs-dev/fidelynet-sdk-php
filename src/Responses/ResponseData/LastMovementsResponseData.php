<?php

namespace Blabs\FidelyNet\Responses\ResponseData;

use Blabs\FidelyNet\Responses\DataModels\WebPosCustomerData;
use Blabs\FidelyNet\Responses\DataModels\WebPosMovementData;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Result of `getlastmovements`. `movements` is always a list, even if the service sends a single object.
 */
final class LastMovementsResponseData extends DataTransferObject
{
    public WebPosCustomerData $customer;

    /** @var WebPosMovementData[] */
    public array $movements;
}
