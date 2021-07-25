<?php

namespace Blabs\FidelyNet\Services;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Requests\CustomerRequestData;
use Blabs\FidelyNet\Responses\DataModels\CustomerData;

final class BackofficeService extends ServiceAbstract
{
    /**
     * @inheritdoc
     */
    public $service_type = ApiServices::BACKOFFICE;

    /**
     * Register a customer and creates a new card (verification code is required).
     *
     * @param CustomerRequestData $customer_data
     * @param int $customerId
     * @param int $campaignId
     *
     * @return CustomerData
     *
     * @throws \Blabs\FidelyNet\Exceptions\FidelyNetServiceException
     * @throws \Blabs\FidelyNet\Exceptions\FidelyNetSessionException
     * @throws \GuzzleHttp\Exception\GuzzleException
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
}
