<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

final class CampaignData extends DataTransferObject
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $code;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $dirLogo;

    /**
     * @var string
     */
    public $pointsTag;

    /**
     * @var string
     */
    public $creditsTag;

    /**
     * @var int
     */
    public $amountLastMovement;

    /**
     * @var int
     */
    public $amountDaysExpiration;

    /**
     * @var int
     */
    public $amountPrizes;

    /**
     * @var mixed
     */
    public $completeCustomerFields;

    /**
     * @var mixed
     */
    public $ticket;

    /**
     * @var mixed
     */
    public $shop;

    /**
     * @var mixed
     */
    public $minimumCustomersFields;
}
