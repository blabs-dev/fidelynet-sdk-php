<?php

namespace Blabs\FidelyNet\Services;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Responses\ResponseData\GetCampaignResponseData;

final class TerminalService extends ServiceAbstract
{
    /**
     * @inheritdoc
     */
    public $service_type = ApiServices::TERMINAL;

    /**
     * Returns information about a specific campaign.
     *
     * @param string $campaignId
     *
     * @throws FidelyNetServiceException
     *
     * @return GetCampaignResponseData
     */
    public function getCampaign(string $campaignId): GetCampaignResponseData
    {
        $api_response = $this->callAction(
            ApiActions::GET_CAMPAIGN,
            [
                'campaignid' => $campaignId,
            ]
        );

        return new GetCampaignResponseData($api_response->data);
    }
}
