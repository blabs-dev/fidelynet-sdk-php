<?php


namespace Blabs\FidelyNet\Services;


use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\ApiSessionTypes;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Responses\ApiResponse;
use Blabs\FidelyNet\Responses\DataModels\CustomerData;
use Blabs\FidelyNet\Responses\Lists\MovementsList;

final class CustomerService extends ServiceAbstract
{

    /**
     * @inheritdoc
     */
    public $service_type = ApiServices::CUSTOMER;

    /**
     * Sends a verification code to certify customer's email address.
     *
     * @param  string $emailAddress
     * @param  string $campaignId
     * @return ApiResponse
     * @throws \Blabs\FidelyNet\Exceptions\FidelyNetServiceException
     * @throws \Blabs\FidelyNet\Exceptions\FidelyNetSessionException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendEmailVerificationCode(string $emailAddress, string $campaignId) :ApiResponse
    {
        return $this->callAction(
            ApiActions::VERIFY_EMAIL, [
            'email' => $emailAddress,
            'campaignid' => $campaignId
            ]
        );
    }

    /**
     * Sends a verification code to certify customer's phone number.
     *
     * @codeCoverageIgnore
     *
     * @param  string $phoneNumber
     * @param  string $campaignId
     * @return ApiResponse
     * @throws \Blabs\FidelyNet\Exceptions\FidelyNetServiceException
     * @throws \Blabs\FidelyNet\Exceptions\FidelyNetSessionException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendMobileVerificationCode(string $phoneNumber, string $campaignId)
    {
        return $this->callAction(
            ApiActions::VERIFY_EMAIL, [
            'mobile' => $phoneNumber,
            'campaignid' => $campaignId
            ]
        );
    }

    /**
     * Register a customer and creates a new card (verification code is required)
     *
     * @param array $customer_data
     * @param $verificationCode
     * @param $campaignId
     * @param $categoryId
     * @param null  $shopId
     *
     * @return CustomerData
     *
     * @throws \Blabs\FidelyNet\Exceptions\FidelyNetServiceException
     * @throws \Blabs\FidelyNet\Exceptions\FidelyNetSessionException
     */
    public function registerCustomerWithVerificationCode(array $customer_data, $verificationCode, $campaignId, $categoryId, $shopId = null) :CustomerData
    {
        $request_data = array_merge(
            [
            'verificationcode' => $verificationCode,
            'campaignid' => $campaignId,
            'categoryid' => $categoryId,
            'registrationshopid' => $shopId,
            ], $customer_data
        );

        $response = $this->callAction(ApiActions::REGISTER_WITH_VC, $request_data);
        return new CustomerData($response->data['customer']);
    }

    /**
     * Get movements list for the customer that opened the session
     *
     * @param int $pageNumber
     * @param int $movementsPerPage
     *
     * @return MovementsList
     *
     * @throws \Blabs\FidelyNet\Exceptions\FidelyNetServiceException
     * @throws \Blabs\FidelyNet\Exceptions\FidelyNetSessionException
     */
    public function getMovements(int $pageNumber, int $movementsPerPage) :MovementsList
    {
        if ($this->getSessionType() !== ApiSessionTypes::PRIVATE) {
            throw new FidelyNetServiceException(Messages::UNSUPPORTED_ACTION_WITH_PUBLIC_SESSION);
        }

        $startOffset = $pageNumber === 1 ? 0 : $pageNumber * $movementsPerPage;

        $request_data = [
            'initlimit' => $startOffset,
            'rowcount'  => $movementsPerPage
        ];

        $response = $this->callAction(ApiActions::GET_MOVEMENTS, $request_data);
        $movements = array_key_exists('movements', $response->data) ? $response->data['movements'] : [];
        return new MovementsList(['movements' => $movements, 'pagination' => $response->data['pagination']]);
    }
}
