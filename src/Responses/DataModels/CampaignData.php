<?php


namespace Blabs\FidelyNet\Responses\DataModels;


use Spatie\DataTransferObject\DataTransferObject;

final class CampaignData extends DataTransferObject
{
    /**
     * 
     *
     * @var int $id 
     */
    public $id;

    /**
     * 
     *
     * @var int $code 
     */
    public $code;

    /**
     * 
     *
     * @var string $name 
     */
    public $name;

    /**
     * 
     *
     * @var string $description 
     */
    public $description;

    /**
     * 
     *
     * @var string $dirLogo 
     */
    public $dirLogo;

    /**
     * 
     *
     * @var string $pointsTag 
     */
    public $pointsTag;

    /**
     * 
     *
     * @var string $creditsTag 
     */
    public $creditsTag;

    /**
     * 
     *
     * @var int $amountLastMovement 
     */
    public $amountLastMovement;

    /**
     * 
     *
     * @var int $amountDaysExpiration 
     */
    public $amountDaysExpiration;

    /**
     * 
     *
     * @var int $amountPrizes 
     */
    public $amountPrizes;

    /**
     * 
     *
     * @var mixed $completeCustomerFields 
     */
    public $completeCustomerFields;

    /**
     * 
     *
     * @var mixed $ticket 
     */
    public $ticket;

    /**
     * 
     *
     * @var mixed $shop 
     */
    public $shop;

    /**
     * 
     *
     * @var mixed $minimumCustomersFields 
     */
    public $minimumCustomersFields;
}
