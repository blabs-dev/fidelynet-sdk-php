<?php

namespace Blabs\FidelyNet\Responses\ResponseData;

use Blabs\FidelyNet\Responses\DataModels\WebPosCustomerData;
use Blabs\FidelyNet\Responses\DataModels\WebPosMovementData;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Result of `newcard` (activation of a dormant card). `movement->kind` is 1.
 */
final class ActivateCardResponseData extends DataTransferObject
{
    public WebPosCustomerData $customer;

    public WebPosMovementData $movement;

    /** Raw shop payload (shop data and rights). */
    public array $shop;
}
