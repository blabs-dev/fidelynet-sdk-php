<?php


namespace Blabs\FidelyNet;

use Blabs\FidelyNet\Constants\ApiMessages;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\ApiSessionTypes;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Constants\Release;
use Blabs\FidelyNet\Contracts\SessionIdProviderContract;
use Blabs\FidelyNet\Exceptions\BadRequestException;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Responses\ApiResponse;
use Blabs\FidelyNet\Session\SessionManager;
use Exception;
use GrahamCampbell\GuzzleFactory\GuzzleFactory;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

final class Client
{
    /**
     * Service type of current instance
     *
     * @var string
     */
    private $service_type;

    /**
     * Requests are made in FNET demo environment
     *
     * @var boolean
     */
    private $demoMode;

    /**
     * SessionManager instance for the current Client
     *
     * @var SessionManager
     */
    private $sessionManager;

    /**
     * Guzzle client used to perform requests
     *
     * @var ClientInterface
     */
    private $http_client;

    /**
     * Service entrypoint
     *
     * @var string
     */
    private $baseURI;

    /**
     * Number of requests made by this instance
     *
     * @var int
     */
    private $requestCount = 0;

    /**
     * Session type opened by this instance (can be 'public' or 'private')
     *
     * @var string
     */
    private $sessionType;

    /**
     * If true a session is started automatically when an instance of the Client is created
     *
     * @var bool
     */
    private $startSession;

    /**
     * Client constructor.
     *
     * @param string $service_type
     * @param array $credentials
     * @param false $demoMode
     * @param string $session_type
     * @param SessionIdProviderContract|null $sessionIdProvider
     * @param ClientInterface|null $http_client
     * @param bool $startSession
     */
    public function __construct(
        string $service_type,
        array $credentials,
        $demoMode = false,
        string $session_type = ApiSessionTypes::PRIVATE,
        SessionIdProviderContract $sessionIdProvider = null,
        ClientInterface $http_client = null,
        bool $startSession = true
    ) {
        $this->service_type = $service_type;
        $this->demoMode = $demoMode;

        $this->baseURI = Constants\ApiServices::ENTRYPOINTS[$service_type];

        // @codeCoverageIgnoreStart
        $this->http_client = $http_client ? $http_client
            : new GuzzleClient(
                [
                'handler' => GuzzleFactory::handler(),
                'base_uri' => $this->baseURI,
                ]
            );
        // @codeCoverageIgnoreEnd

        $this->sessionType = $session_type;
        $this->startSession = $startSession;
        $this->setupSessionManager($credentials, $sessionIdProvider);
    }

    /**
     * Init the Session Manager using the id provider specified in this instance
     *
     * @param array                          $credentials
     * @param SessionIdProviderContract|null $sessionIdProvider
     */
    private function setupSessionManager(array $credentials, SessionIdProviderContract $sessionIdProvider): void
    {
        $this->sessionManager = new SessionManager($credentials, $this->sessionType, $sessionIdProvider, $this);
        if ($this->startSession)
            $this->initSession();
    }

    /**
     * Starts a session on current instance FNET3 service
     */
    public function initSession()
    {
        if (empty($this->getSessionId())) {
            $this->sessionManager->initSession();
        }
    }

    /**
     * Returns service type of current instance
     *
     * @return string
     */
    public function getServiceType(): string
    {
        return $this->service_type;
    }

    /**
     * Returns session type of current instance
     *
     * @return string
     */
    public function getSessionType()
    {
        return $this->sessionManager->getSessionType();
    }

    /**
     * Returns session id current instance
     *
     * @return string|null
     */
    public function getSessionId()
    {
        return $this->sessionManager->getSessionId();
    }

    /**
     * Get number of sessions opened by this instance
     *
     * @return int
     */
    public function getSessionRenews(): int
    {
        return $this->sessionManager->getSessionRenews();
    }

    /**
     * Returns if the "driver" for the current session managers persists the id across requests
     *
     * @return bool
     */
    public function isSessionPersistent()
    {
        return $this->sessionManager->isSessionPersistent();
    }

    /**
     * Returns number of requests made by this instance
     *
     * @return int
     */
    public function getRequestCount(): int
    {
        return $this->requestCount;
    }

    /**
     * Returns the set of default parameters used for service requests on this instance
     *
     * @param  string|null $action
     * @return array
     */
    public function getDefaultParameters(string $action = null) :array
    {
        switch ($this->service_type) {
        case ApiServices::CUSTOMER:
            $session_id_key = 'session';
            break;
        default:
            $session_id_key = 'sessionid';
        }

        $default_parameters = [
            'az' => $action,
            $session_id_key => $this->getSessionId()
        ];
        return array_merge($default_parameters, $this->demoMode ? ['ambiente' => 'DEMO'] : []);
    }

    /**
     * Returns true if requests are made in FNET demo environment
     *
     * @return bool
     */
    public function isDemoMode()
    {
        return $this->demoMode;
    }

    /**
     * Prepare the data for the service request using default parameters and setting up headers accordingly
     *
     * @param  string $action
     * @param  array  $parameters
     * @return array
     */
    private function prepareRequest(string $action, array $parameters) :array
    {
        return array_merge(
            $this->getDefaultParameters($action),
            $parameters
        );
    }

    /**
     * Returns the set of default headers to use for service requests
     *
     * @return array
     */
    private function getHeaders() :array
    {
        return [
            'User-Agent' => Release::USER_AGENT,
            'Accept' => 'application/json'
        ];
    }

    /**
     * Perform a conversion against data array to convert it in multipart/form-data
     * as required by the service
     *
     * @param  array $parameters
     * @return array
     */
    private function convertToMultipart(array $parameters): array
    {
        $multipart = [];

        foreach ($parameters as $key => $value) {
            $multipart[] = [
                'name' => $key,
                'contents' => $value,
            ];
        }

        return $multipart;
    }

    /**
     * Performs the action request to the service
     *
     * @param string $action
     * @param array  $parameters
     *
     * @return ApiResponse
     *
     * @throws Exceptions\FidelyNetSessionException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function actionRequest(string $action, array $parameters) :ApiResponse
    {
        $this->requestCount++;

        $parameters = $this->prepareRequest($action, $parameters);

        try {
            $options = [
                'headers' => $this->getHeaders(),
                'multipart' => $this->convertToMultipart($parameters),
            ];
            $response = $this->http_client->post('', $options);
        } catch (Exception $exception) {
            throw $this->determineClientException($exception);
        }

        $response_data = $this->parseResponse($response->getBody()->getContents());

        // If service returns an expired session error, session is renewed and request is performed again
        if ($response_data->returncode == 998) {
            $this->sessionManager->renewSession();
            return $this->actionRequest($action, $parameters);
        }

        if ($response_data->returncode !== 0) {
            throw $this->determineApiError($response_data->returncode);
        }

        return $response_data;
    }

    /**
     * Parses the service response to a common DTO format
     *
     * @param  string $response_content
     * @return ApiResponse
     */
    protected function parseResponse(string $response_content) :ApiResponse
    {
        $parsed_response = json_decode($response_content, true);
        return new ApiResponse($parsed_response);
    }

    /**
     * Determines the error returned by the service
     *
     * @param  string|int $return_code Error code provided by service
     * @return Exception
     */
    protected function determineApiError($return_code) :Exception
    {
        if ($return_code === '9999') {
            return new FidelyNetServiceException(Messages::SERVICE_BAD_REQUEST);
        }

        $message = ApiMessages::CODES[$return_code];
        return new FidelyNetServiceException(Messages::SERVICE_RETURNED_ERROR_CODE . "{$return_code}: {$message}");
    }

    /**
     * Determines the exception throwed by Guzzle client
     *
     * @param  $exception
     * @return Exception
     */
    protected function determineClientException($exception): Exception
    {
        if ($exception instanceof ClientException) {
            if ($exception->getResponse()->getStatusCode() >= 400) {
                return new BadRequestException(Messages::SERVICE_BAD_REQUEST);
            }
        }

        if ($exception instanceof ConnectException) {
            return new FidelyNetServiceException(Constants\Messages::SERVICE_UNREACHABLE);
        }

        // @codeCoverageIgnoreStart
        return new FidelyNetServiceException(Constants\Messages::UNKNOWN_ERROR);
        // @codeCoverageIgnoreEnd
    }
}
