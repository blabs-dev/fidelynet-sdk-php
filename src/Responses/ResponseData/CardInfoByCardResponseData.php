<?php

namespace Blabs\FidelyNet\Responses\ResponseData;

use Blabs\FidelyNet\Responses\DataModels\WebPosCustomerData;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Result of `getinfobycard`. A dormant card (returncode 53) is a valid state: `dormant` is true,
 * `customer->id` is 0 and the card can be activated.
 */
final class CardInfoByCardResponseData extends DataTransferObject
{
    public const RETURN_CODE_DORMANT = 53;

    public int $returnCode;

    public bool $dormant;

    public WebPosCustomerData $customer;
}
