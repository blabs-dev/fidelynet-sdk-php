<?php

namespace Blabs\FidelyNet\Services;

use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\ApiSessionTypes;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Exceptions\FidelyNetSessionException;
use Blabs\FidelyNet\Requests\CustomerRequestData;
use Blabs\FidelyNet\Responses\ApiResponse;
use Blabs\FidelyNet\Responses\DataModels\CustomerData;
use Blabs\FidelyNet\Responses\Lists\MovementsList;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class CustomerService extends ServiceAbstract
{
    /**
     * @inheritdoc
     */
    public string $service_type = ApiServices::CUSTOMER;

    /**
     * Sends a verification code to certify customer's email address.
     *
     * @param string $emailAddress
     * @param string $campaignId
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     *
     * @return ApiResponse
     */
    public function sendEmailVerificationCode(string $emailAddress, string $campaignId): ApiResponse
    {
        return $this->callAction(
            ApiActions::VERIFY_EMAIL,
            [
                'email'      => $emailAddress,
                'campaignid' => $campaignId,
            ]
        );
    }

    /**
     * Sends a verification code to certify customer's phone number.
     *
     * @codeCoverageIgnore
     *
     * @param string $phoneNumber
     * @param string $campaignId
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     *
     * @return ApiResponse
     */
    public function sendMobileVerificationCode(string $phoneNumber, string $campaignId): ApiResponse
    {
        return $this->callAction(
            ApiActions::VERIFY_EMAIL,
            [
                'mobile'     => $phoneNumber,
                'campaignid' => $campaignId,
            ]
        );
    }

    /**
     * Register a customer and creates a new card (verification code is required).
     *
     * @param array $customer_data
     * @param $verificationCode
     * @param $campaignId
     * @param $categoryId
     * @param null $shopId
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     *
     * @return CustomerData
     */
    public function registerCustomerWithVerificationCode(array $customer_data, $verificationCode, $campaignId, $categoryId, $shopId = null): CustomerData
    {
        $request_data = array_merge(
            [
                'verificationcode'   => $verificationCode,
                'campaignid'         => $campaignId,
                'categoryid'         => $categoryId,
                'registrationshopid' => $shopId,
            ],
            $customer_data
        );

        $response = $this->callAction(ApiActions::REGISTER_WITH_CODE, $request_data);

        return new CustomerData($response->data['customer']);
    }

    /**
     * Register a customer and creates a new card (verification code is required).
     *
     * @param CustomerRequestData $customer_data
     * @param $campaignId
     * @param $categoryId
     * @param null $shopId
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     *
     * @return CustomerData
     */
    public function registerCustomer(CustomerRequestData $customer_data, $campaignId, $categoryId, $shopId = null): CustomerData
    {
        $request_data = array_merge(
            $customer_data->toArray(),
            [
                'campaignid'         => $campaignId,
                'categoryid'         => $categoryId,
                'registrationshopid' => $shopId,
            ]
        );

        $response = $this->callAction(ApiActions::REGISTER_WITHOUT_CODE, $request_data);

        $attributes = array_merge(
            $response->data['customer'],
            $response->data3['customer']['personalInfo']
        );
        $attributes['registrationShopId'] = array_key_exists('registrationShopId', $response->data3) ?
            $response->data3['registrationShopId'] : '';

        $customer_data = new CustomerData($attributes);

        return $customer_data;
    }

    /**
     * Get movements list for the customer that opened the session.
     *
     * @param int $pageNumber
     * @param int $movementsPerPage
     *
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     *
     * @return MovementsList
     */
    public function getMovements(int $pageNumber, int $movementsPerPage): MovementsList
    {
        if ($this->getSessionType() !== ApiSessionTypes::PRIVATE) {
            throw new FidelyNetServiceException(Messages::UNSUPPORTED_ACTION_WITH_PUBLIC_SESSION);
        }

        $startOffset = $pageNumber === 1 ? 0 : $pageNumber * $movementsPerPage;

        $request_data = [
            'initlimit' => $startOffset,
            'rowcount'  => $movementsPerPage,
        ];

        $response = $this->callAction(ApiActions::GET_MOVEMENTS, $request_data);
        $movements = array_key_exists('movements', $response->data) ? $response->data['movements'] : [];

        return new MovementsList(['movements' => $movements, 'pagination' => $response->data['pagination']]);
    }
}
