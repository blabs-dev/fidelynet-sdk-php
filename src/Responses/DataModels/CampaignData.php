<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class CampaignData extends DataTransferObject
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var int
     */
    public int $code;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var string
     */
    public string $dirLogo;

    /**
     * @var string
     */
    public string $pointsTag;

    /**
     * @var string
     */
    public string $creditsTag;

    /**
     * @var int
     */
    public int $amountLastMovement;

    /**
     * @var int
     */
    public int $amountDaysExpiration;

    /**
     * @var int
     */
    public int $amountPrizes;

    /**
     * @var mixed
     */
    public mixed $completeCustomerFields;

    /**
     * @var mixed
     */
    public mixed $ticket;

    /**
     * @var mixed
     */
    public mixed $shop;

    /**
     * @var mixed
     */
    public mixed $minimumCustomersFields;
}
