<?php

namespace Blabs\FidelyNet\Services;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Exceptions\FidelyNetSessionException;
use Blabs\FidelyNet\Requests\CustomerRequestData;
use Blabs\FidelyNet\Responses\DataModels\CustomerData;
use Blabs\FidelyNet\Responses\ResponseData\CardInfoResponseData;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class BackofficeService extends ServiceAbstract
{
    /**
     * @inheritdoc
     */
    public string $service_type = ApiServices::BACKOFFICE;

    /**
     * Register a customer and creates a new card (verification code is required).
     *
     * @param CustomerRequestData $customer_data
     * @param int $customerId
     * @param int $campaignId
     *
     * @return CustomerData
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function modifyCustomer(CustomerRequestData $customer_data, int $customerId, int $campaignId): CustomerData
    {
        $request_data = array_merge(
            $customer_data->toArray(),
            [
                'id'         => $customerId,
                'campaignid' => $campaignId,
            ]
        );

        $response = $this->callAction(ApiActions::BO_MODIFY_CUSTOMER, $request_data);

        return new CustomerData($response->data['customer']['personalInfo']);
    }

    /**
     * @param int $cardId
     *
     * @return CardInfoResponseData
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function getCardInfo(int $cardId): CardInfoResponseData
    {
        $response = $this->callAction(ApiActions::BO_GET_INFO_CARD, ['card' => $cardId]);

        return new CardInfoResponseData($response->data['customer']);
    }
}
