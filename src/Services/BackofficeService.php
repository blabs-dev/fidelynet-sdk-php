<?php

namespace Blabs\FidelyNet\Services;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Requests\ModifyCustomerRequestData;
use Blabs\FidelyNet\Responses\DataModels\CustomerData;
use Blabs\FidelyNet\Responses\ResponseData\CardInfoResponseData;

final class BackofficeService extends ServiceAbstract
{
    /**
     * @inheritdoc
     */
    public $service_type = ApiServices::BACKOFFICE;

    /**
     * Register a customer and creates a new card (verification code is required).
     *
     * @param ModifyCustomerRequestData $customer_data
     *
     * @return CustomerData
     *
     * @throws \Blabs\FidelyNet\Exceptions\FidelyNetServiceException
     * @throws \Blabs\FidelyNet\Exceptions\FidelyNetSessionException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function modifyCustomer(ModifyCustomerRequestData $customer_data): CustomerData
    {
        $request_data = array_filter($customer_data->toArray());

        $response = $this->callAction(ApiActions::BO_MODIFY_CUSTOMER, $request_data);

        return new CustomerData($response->data['customer']['personalInfo']);
    }

    public function getCardInfo(int $cardId)
    {
        $response = $this->callAction(ApiActions::BO_GET_INFO_CARD, ['card' => $cardId]);

        return new CardInfoResponseData($response->data['customer']);
    }
}
