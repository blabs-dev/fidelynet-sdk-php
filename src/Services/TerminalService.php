<?php

namespace Blabs\FidelyNet\Services;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Exceptions\FidelyNetSessionException;
use Blabs\FidelyNet\Responses\DataModels\CustomerData;
use Blabs\FidelyNet\Responses\ResponseData\CardInfoResponseData;
use Blabs\FidelyNet\Responses\ResponseData\GetCampaignResponseData;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class TerminalService extends ServiceAbstract
{
    /**
     * @inheritdoc
     */
    public string $service_type = ApiServices::TERMINAL;

    /**
     * Returns information about a specific campaign.
     *
     * @param string $campaignId
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
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

    public function checkCard(int $campaignId, string $cardIdentifier)
    {
        $api_response = $this
            ->callAction(
            ApiActions::TERM_CHECK_CARD,
                [
                    'campaignid' => $campaignId,
                    'card' => $cardIdentifier,
                    // 'autounlock' => 'N', // ??
                ],
                ApiServices::ENTRYPOINTS[ApiServices::TERMINAL_MOBILE]
            );
        return new CardInfoResponseData($api_response->data['customer']);
    }
}
