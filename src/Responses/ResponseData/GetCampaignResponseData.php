<?php


namespace Blabs\FidelyNet\Responses\ResponseData;


use Spatie\DataTransferObject\DataTransferObject;

final class GetCampaignResponseData extends DataTransferObject
{
    /**
     * 
     *
     * @var int|null 
     */
    public $answerCode;

    /**
     * 
     *
     * @var \Blabs\FidelyNet\Responses\DataModels\CampaignData 
     */
    public $campaign;

    /**
     * 
     *
     * @var \Blabs\FidelyNet\Responses\DataModels\TerminalData 
     */
    public $terminal;

}
