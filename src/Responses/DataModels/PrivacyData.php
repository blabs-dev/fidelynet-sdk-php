<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

class PrivacyData extends DataTransferObject
{
    /**
     * @var mixed
     */
    public mixed $flags;
    /**
     * @var bool|null
     */
    public ?bool $usedForPromotions;
    /**
     * @var bool
     */
    public ?bool $usedForStatistics;
    /**
     * @var bool|null
     */
    public ?bool $usedByOthers;
    /**
     * @var bool|null
     */
    public ?bool $canGetCurrentLocation;
    /**
     * @var bool|null
     */
    public ?bool $canComunicaVerification;
}
