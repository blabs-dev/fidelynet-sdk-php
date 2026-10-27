<?php

namespace Blabs\FidelyNet\Services;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Exceptions\FidelyNetSessionException;
use Blabs\FidelyNet\Responses\DataModels\BarcodeCardData;
use Blabs\FidelyNet\Responses\DataModels\CategoryData;
use Blabs\FidelyNet\Responses\DataModels\CustomerData;
use Blabs\FidelyNet\Responses\DataModels\CustomerInfoData;
use Blabs\FidelyNet\Responses\DataModels\LoggedShopData;
use Blabs\FidelyNet\Responses\DataModels\MovementData;
use Blabs\FidelyNet\Responses\DataModels\WebPosCustomerData;
use Blabs\FidelyNet\Responses\DataModels\WebPosMovementData;
use Blabs\FidelyNet\Responses\ResponseData\ActivateCardResponseData;
use Blabs\FidelyNet\Responses\ResponseData\CancelLastTransactionResponseData;
use Blabs\FidelyNet\Responses\ResponseData\CardInfoByCardResponseData;
use Blabs\FidelyNet\Responses\ResponseData\CardInfoResponseData;
use Blabs\FidelyNet\Responses\ResponseData\GetCampaignResponseData;
use Blabs\FidelyNet\Responses\ResponseData\LastMovementsResponseData;
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
                ApiActions::TERM_DISCHARGE_POINTS,
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

    /**
     * Decodes a card barcode (13-14 digits) into campaign code and card number.
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function getCardFromBarcode(string $barcode): BarcodeCardData
    {
        $api_response = $this->callAction(
            ApiActions::TERM_GET_CARD_FROM_BARCODE,
            ['barcode' => $barcode]
        );

        return BarcodeCardData::fromApiData($api_response->data);
    }

    /**
     * Reads a card by number and campaign code (`getinfobycard`).
     *
     * Return code 53 means "dormant card" (in the whitelist but not activated yet): it is a valid state and
     * does not throw. Check `$result->dormant` to tell it apart from an active card. Other codes throw
     * a FidelyNetServiceException carrying the service code (e.g. 59: card not in whitelist).
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function getCardInfoByCard(int|string $card, int|string $campaignCode): CardInfoByCardResponseData
    {
        $api_response = $this->callAction(
            ApiActions::TERM_GET_INFO_BY_CARD,
            [
                'card'          => $card,
                'campaigncode'  => $campaignCode,
                'flazzerapunti' => 'N',
            ],
            '',
            [CardInfoByCardResponseData::RETURN_CODE_DORMANT]
        );

        return new CardInfoByCardResponseData(
            returnCode: $api_response->returncode,
            dormant: $api_response->returncode === CardInfoByCardResponseData::RETURN_CODE_DORMANT,
            customer: WebPosCustomerData::fromApiData($api_response->data['customer']),
        );
    }

    /**
     * Activates ("baptises") a dormant card with the placeholder customer `*` `*`, gender `N`.
     *
     * Activation cannot be undone. Error codes (preserved in the exception service code): 58 card already
     * exists, 995 card previously activated, 56 card not in campaign, 57 card unusable on this terminal,
     * 1004 missing authorizations.
     *
     * @param int|string $campaignId `customer.campaignId` from the dormant `getinfobycard`
     * @param int|string $card       Card number
     * @param string     $fidelyCode Barcode read ('' if the campaign does not use fidelycard)
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function activateCard(int|string $campaignId, int|string $card, string $fidelyCode = ''): ActivateCardResponseData
    {
        $empty_fields = [
            'identitycard', 'birthdate', 'notes', 'flags', 'usedforpromotions', 'usedforstatistics', 'usedbyothers',
            'cangetcurrentlocation', 'cancomunicaverification', 'mailcontactdata', 'mobilecontactdata',
            'telephonecontactdata', 'faxcontactdata', 'address', 'addressnumber', 'addressprefix', 'zip', 'country',
            'geolevel1', 'geolevel2', 'geolevel3', 'geolevel4', 'geolevel5', 'facebookid', 'customerdynamicfields',
            'interestareas',
        ];

        $api_response = $this->callAction(
            ApiActions::TERM_NEW_CARD,
            array_merge(array_fill_keys($empty_fields, ''), [
                'campaignid'       => $campaignId,
                'card'             => $card,
                'fidelycode'       => $fidelyCode,
                'username'         => $card,
                'name'             => '*',
                'surname'          => '*',
                'gender'           => 'N',
                'parentcustomerid' => 0,
                'mlmcustomerid'    => 0,
            ])
        );

        return new ActivateCardResponseData(
            customer: WebPosCustomerData::fromApiData($api_response->data['customer']),
            movement: WebPosMovementData::fromApiData($api_response->data['movement']),
            shop: $api_response->data['shop'] ?? [],
        );
    }

    /**
     * Cancels the LAST movement of the customer, whatever it is (even the activation: callers should check it
     * with getLastMovements() first). Error codes: 126 not cancellable, 133 already cancelled, 150 not found,
     * 1004 missing authorizations.
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function cancelLastTransaction(int|string $customerId, string $notes = ''): CancelLastTransactionResponseData
    {
        $api_response = $this->callAction(
            ApiActions::TERM_CANCEL_LAST_TRANSACTION,
            [
                'customerid' => $customerId,
                'notes'      => $notes,
            ]
        );

        return new CancelLastTransactionResponseData(
            customer: WebPosCustomerData::fromApiData($api_response->data['customer']),
            movement: WebPosMovementData::fromApiData($api_response->data['movement']),
            shop: $api_response->data['shop'] ?? [],
        );
    }

    /**
     * Returns the latest movements of a customer. The service sends `movements` as a single object when
     * `rowCount` is 1 and as an array otherwise: here it is always a list.
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function getLastMovements(
        int|string $campaignId,
        int|string $customerId,
        int $initLimit = 0,
        int $rowCount = 1
    ): LastMovementsResponseData {
        $api_response = $this->callAction(
            ApiActions::TERM_GET_LAST_MOVEMENTS,
            [
                'campaignid' => $campaignId,
                'customerid' => $customerId,
                'initlimit'  => $initLimit,
                'rowcount'   => $rowCount,
            ]
        );

        $movements = $api_response->data['movements'] ?? [];
        if (is_array($movements) && array_key_exists('id', $movements)) {
            $movements = [$movements];
        }

        return new LastMovementsResponseData(
            customer: WebPosCustomerData::fromApiData($api_response->data['customer']),
            movements: array_map(fn (array $movement) => WebPosMovementData::fromApiData($movement), array_values($movements)),
        );
    }
}
