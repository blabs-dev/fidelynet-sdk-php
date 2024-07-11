<?php

namespace Blabs\FidelyNet\Services;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Exceptions\FidelyNetSessionException;
use Blabs\FidelyNet\Responses\DataModels\CategoryData;
use Blabs\FidelyNet\Responses\DataModels\CustomerData;
use Blabs\FidelyNet\Responses\DataModels\CustomerInfoData;
use Blabs\FidelyNet\Responses\DataModels\LoggedShopData;
use Blabs\FidelyNet\Responses\DataModels\MovementData;
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
            ApiActions::TERM_GET_CAMPAIGN,
            [
                'campaignid' => $campaignId,
            ]
        );

        return new GetCampaignResponseData($api_response->data);
    }

    public function checkCard(int $campaignId, string $cardIdentifier, string $username, string $password)
    {
        $api_response = $this
            ->callAction(
                ApiActions::TERM_CHECK_CARD,
                [
                    'campaignid' => $campaignId,
                    'card'       => $cardIdentifier,
                    'username'   => $username,
                    'password'   => $password,
                    // 'autounlock' => 'N', // ??
                ],
                ApiServices::ENTRYPOINTS[ApiServices::TERMINAL_MOBILE]
            );

        return new CardInfoResponseData($api_response->data['customer']);
    }

    /**
     * @throws UnknownProperties
     * @throws FidelyNetSessionException
     * @throws FidelyNetServiceException
     * @throws GuzzleException
     */
    public function getCategories($resultsOffset = 0, $maxResults = 1000)
    {
        $api_response = $this->callAction(ApiActions::TERM_GET_CATEGORIES, [
            'initlimit' => $resultsOffset,
            'rowcount'  => $maxResults,
        ]);
        $categories = $api_response->data['category'];

        return array_map(
            fn (array $category_attributes) => new CategoryData($category_attributes),
            $categories
        );
    }

    public function getLoggedShopInfo()
    {
        $api_response = $this
            ->callAction(
                ApiActions::TERM_GET_LOGGED_SHOP_INFO,
                []
            );

        return new LoggedShopData($api_response->data['shop']);
    }

    public function getCardInfo(string $card): CustomerInfoData
    {
        $api_response = $this
            ->callAction(
                ApiActions::TERM_GET_CARD_INFO,
                [
                    'card' => $card
                ]
            );

        return new CustomerInfoData($api_response->data['customer']);
    }

    public function chargePoints(
        string $cardNumber,
        string $campaignId,
        string $customerId,
        int $mooneyAmount,
        int $cashbackAmount,
    ): MovementData
    {
        $api_response = $this
            ->callAction(
                ApiActions::TERM_CHARGE_POINTS,
                [
                    'campaignid'    => $campaignId,
                    'customerid'    => $customerId,
                    'card'          => $cardNumber,
                    'kindcharge'    => 1,
                    'chargedpoints' => $cashbackAmount,
                    'totalmoney'    => $mooneyAmount,
                ]
            );

        return new MovementData($api_response->data['movement']);
    }

    public function saleMovement(
        string $cardNumber,
        string $campaignId,
        string $customerId,
        int $mooneyAmount,
    ): MovementData
    {
        $api_response = $this
            ->callAction(
                ApiActions::TERM_SALE_PRODUCT,
                [
                    'campaignid'    => $campaignId,
                    'customerid'    => $customerId,
                    'card'          => $cardNumber,
                    'totalmoney'    => $mooneyAmount,
                ]
            );

        return new MovementData($api_response->data['movement']);
    }

    public function disChargePoints(
        string $cardNumber,
        string $campaignId,
        string $customerId,
        int $cashbackAmount,
        int $mooneyAmount,
    ): MovementData
    {
        $api_response = $this
            ->callAction(
                ApiActions::TERM_CHARGE_POINTS,
                [
                    'campaignid'    => $campaignId,
                    'customerid'    => $customerId,
                    'card'          => $cardNumber,
                    'kindcharge'    => 1,
                    'dischargedpoints' => $cashbackAmount,
                    'totalmoney'    => $mooneyAmount,
                ]
            );

        return new MovementData($api_response->data['movement']);
    }
}
