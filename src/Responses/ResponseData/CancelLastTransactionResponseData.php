<?php

namespace Blabs\FidelyNet\Responses\ResponseData;

use Blabs\FidelyNet\Responses\DataModels\WebPosCustomerData;
use Blabs\FidelyNet\Responses\DataModels\WebPosMovementData;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Result of `cancellasttransaction`. `movement` has the same id as the cancelled movement, with kind 13.
 */
final class CancelLastTransactionResponseData extends DataTransferObject
{
    public WebPosCustomerData $customer;

    public WebPosMovementData $movement;

    /** Raw shop payload (shop data and rights). */
    public array $shop;
}
