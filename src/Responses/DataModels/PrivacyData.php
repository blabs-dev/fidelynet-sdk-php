<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

class PrivacyData extends DataTransferObject
{
    /**
     * @var int
     */
    public int $flags;
    /**
     * @var bool
     */
    public bool $usedForPromotions;
    /**
     * @var bool
     */
    public bool $usedForStatistics;
    /**
     * @var bool
     */
    public bool $usedByOthers;
    /**
     * @var bool
     */
    public bool $canGetCurrentLocation;
    /**
     * @var bool
     */
    public bool $canComunicaVerification;
}
