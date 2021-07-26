<?php

namespace Blabs\FidelyNet\Responses\ResponseData;

use Blabs\FidelyNet\Responses\DataModels\CampaignData;
use Blabs\FidelyNet\Responses\DataModels\TerminalData;
use Spatie\DataTransferObject\DataTransferObject;

final class GetCampaignResponseData extends DataTransferObject
{
    /**
     * @var int|null
     */
    public ?int $answerCode;

    /**
     * @var CampaignData
     */
    public CampaignData $campaign;

    /**
     * @var TerminalData
     */
    public TerminalData $terminal;
}
