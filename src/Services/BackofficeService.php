<?php

namespace Blabs\FidelyNet\Services;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Exceptions\FidelyNetSessionException;
use Blabs\FidelyNet\Requests\ModifyCustomerRequestData;
use Blabs\FidelyNet\Responses\DataModels\CustomerInfoData;
use Blabs\FidelyNet\Responses\DataModels\DynamicField;
use Blabs\FidelyNet\Responses\Lists\MovementListBackOffice;
use Blabs\FidelyNet\Responses\ResponseData\CardInfoResponseData;
use Blabs\FidelyNet\Responses\ResponseData\GetDynamicFieldsResponseData;
use DateTime;
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
     * @param ModifyCustomerRequestData $customer_data
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     *
     * @return CustomerInfoData
     */
    public function modifyCustomer(ModifyCustomerRequestData $customer_data): CustomerInfoData
    {
        $request_data = array_filter($customer_data->toArray());

        $response = $this->callAction(ApiActions::BO_MODIFY_CUSTOMER, $request_data);

        return new CustomerInfoData($response->data['customer']);
    }

    /**
     * @param int $cardId
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     *
     * @return CardInfoResponseData
     */
    public function getCardInfo(int $cardId): CardInfoResponseData
    {
        $response = $this->callAction(ApiActions::BO_GET_INFO_CARD, ['card' => $cardId]);

        return new CardInfoResponseData($response->data['customer']);
    }

    /**
     * @param int $maxResults
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     *
     * @return DynamicField[]
     */
    public function getDynamicFields(int $maxResults = 100): array
    {
        $response = $this->callAction(ApiActions::BO_GET_DYNAMIC_FIELDS, ['rowcount' => $maxResults]);

        $data = new GetDynamicFieldsResponseData($response->data);

        return $data->dynamicFields;
    }

    public function getMovementList(string $cardNumber, DateTime $initDate, DateTime $endDate): MovementListBackOffice
    {
        $response = $this->callAction(ApiActions::BO_GET_MOVEMENT_LIST, [
            'card' => $cardNumber,
            'initDate' => $initDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d')
        ]);

        return  MovementListBackOffice::createFromApiResponse($response);
    }
}
