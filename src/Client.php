<?php

namespace Blabs\FidelyNet;

use Blabs\FidelyNet\Constants\ApiMessages;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\ApiSessionTypes;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Contracts\SessionIdProviderContract;
use Blabs\FidelyNet\Exceptions\BadRequestException;
use Blabs\FidelyNet\Exceptions\CustomerNotFoundException;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Exceptions\GeoLevelNotFoundException;
use Blabs\FidelyNet\Exceptions\MissingRequiredFieldsException;
use Blabs\FidelyNet\Exceptions\UnauthorizedActionException;
use Blabs\FidelyNet\Responses\ApiResponse;
use Blabs\FidelyNet\Session\SessionManager;
use Blabs\FidelyNet\Support\UserAgentHelper;
use Exception;
use GrahamCampbell\GuzzleFactory\GuzzleFactory;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class Client
{
    /**
     * Service type of current instance.
     *
     * @var string
     */
    private string $service_type;

    /**
     * Requests are made in FNET demo environment.
     *
     * @var bool
     */
    private bool $demoMode;

    /**
     * SessionManager instance for the current Client.
     *
     * @var SessionManager
     */
    private SessionManager $sessionManager;

    /**
     * Guzzle client used to perform requests.
     *
     * @var ClientInterface
     */
    private ClientInterface $http_client;

    /**
     * Service entrypoint.
     *
     * @var string
     */
    private string $baseURI;

    /**
     * Number of requests made by this instance.
     *
     * @var int
     */
    private int $requestCount = 0;

    /**
     * Session type opened by this instance (can be 'public' or 'private').
     *
     * @var string
     */
    private string $sessionType;

    /**
     * If true a session is started automatically when an instance of the Client is created.
     *
     * @var bool
     */
    private bool $startSession;

    /**
     * Client constructor.
     *
     * @param string                         $service_type
     * @param array                          $credentials
     * @param false                          $demoMode
     * @param string                         $session_type
     * @param SessionIdProviderContract|null $sessionIdProvider
     * @param ClientInterface|null           $http_client
     * @param bool                           $startSession
     */
    public function __construct(
        string $service_type,
        array $credentials,
        bool $demoMode = false,
        string $session_type = ApiSessionTypes::PRIVATE,
        SessionIdProviderContract $sessionIdProvider = null,
        ClientInterface $http_client = null,
        bool $startSession = true
    ) {
        $this->service_type = $service_type;
        $this->demoMode = $demoMode;

        $this->baseURI = Constants\ApiServices::ENTRYPOINTS[$service_type];

        // @codeCoverageIgnoreStart
        $this->http_client = $http_client ?: new GuzzleClient(
            [
                'handler'  => GuzzleFactory::handler(),
                'base_uri' => $this->baseURI,
            ]
        );
        // @codeCoverageIgnoreEnd

        $this->sessionType = $session_type;
        $this->startSession = $startSession;
        $this->setupSessionManager($credentials, $sessionIdProvider);
    }

    /**
     * Init the Session Manager using the id provider specified in this instance.
     *
     * @param array                     $credentials
     * @param SessionIdProviderContract $sessionIdProvider
     */
    private function setupSessionManager(array $credentials, SessionIdProviderContract $sessionIdProvider): void
    {
        $this->sessionManager = new SessionManager($credentials, $this->sessionType, $sessionIdProvider, $this);
        if ($this->startSession) {
            $this->initSession();
        }
    }

    /**
     * Starts a session on current instance FNET3 service.
     */
    public function initSession(): void
    {
        if (empty($this->getSessionId())) {
            $this->sessionManager->initSession();
        }
    }

    /**
     * Returns service type of current instance.
     *
     * @return string
     */
    public function getServiceType(): string
    {
        return $this->service_type;
    }

    /**
     * Returns session type of current instance.
     *
     * @return string
     */
    public function getSessionType(): string
    {
        return $this->sessionManager->getSessionType();
    }

    /**
     * Returns session id current instance.
     *
     * @return string|null
     */
    public function getSessionId(): ?string
    {
        return $this->sessionManager->getSessionId();
    }

    /**
     * Get number of sessions opened by this instance.
     *
     * @return int
     */
    public function getSessionRenews(): int
    {
        return $this->sessionManager->getSessionRenews();
    }

    /**
     * Returns if the "driver" for the current session managers persists the id across requests.
     *
     * @return bool
     */
    public function isSessionPersistent(): bool
    {
        return $this->sessionManager->isSessionPersistent();
    }

    /**
     * Returns number of requests made by this instance.
     *
     * @return int
     */
    public function getRequestCount(): int
    {
        return $this->requestCount;
    }

    /**
     * Returns the set of default parameters used for service requests on this instance.
     *
     * @param string|null $action
     *
     * @return array
     */
    public function getDefaultParameters(string $action = null): array
    {
        $session_id_key = match ($this->service_type) {
            ApiServices::CUSTOMER => 'session',
            default               => 'sessionid',
        };

        if (in_array($action, ApiServices::ACTIONS_THAT_USES_SESSION_PARAMETER)) {
            $session_id_key = 'session';
        }

        $default_parameters = [
            'az'            => $action,
            $session_id_key => $this->getSessionId(),
        ];

        return array_merge(
            $default_parameters,
            $this->demoMode ?
                ['ambiente' => 'DEMO']
                : ['ambiente' => 'PROD']
        );
    }

    /**
     * Returns true if requests are made in FNET demo environment.
     *
     * @return bool
     */
    public function isDemoMode(): bool
    {
        return $this->demoMode;
    }

    /**
     * Prepare the data for the service request using default parameters and setting up headers accordingly.
     *
     * @param string $action
     * @param array  $parameters
     *
     * @return array
     */
    private function prepareRequest(string $action, array $parameters): array
    {
        return array_merge(
            $this->getDefaultParameters($action),
            $parameters
        );
    }

    /**
     * Returns the set of default headers to use for service requests.
     *
     * @return array
     */
    #[ArrayShape(['User-Agent' => 'string', 'Accept' => 'string'])]
 private function getHeaders(): array
 {
     return [
         'User-Agent' => UserAgentHelper::getUserAgent(),
         'Accept'     => 'application/json',
     ];
 }

    /**
     * Perform a conversion against data array to convert it in multipart/form-data
     * as required by the service.
     *
     * @param array $parameters
     *
     * @return array
     */
    private function convertToMultipart(array $parameters): array
    {
        $multipart = [];

        foreach ($parameters as $key => $value) {
            $multipart[] = [
                'name'     => $key,
                'contents' => $value,
            ];
        }

        return $multipart;
    }

    /**
     * Performs the action request to the service.
     *
     * @param string $action
     * @param array  $parameters
     *
     * @throws Exceptions\FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     *
     * @return ApiResponse
     */
    public function actionRequest(string $action, array $parameters, string $overrideEntrypoint = ''): ApiResponse
    {
        $this->requestCount++;

        $parameters = $this->prepareRequest($action, $parameters);

        if (!empty($overrideEntrypoint)) {
            $this->useEntryPoint($overrideEntrypoint);
        }

        try {
            $options = [
                'headers'   => $this->getHeaders(),
                'multipart' => $this->convertToMultipart($parameters),
            ];
            $response = $this->http_client->post($this->baseURI, $options);
        } catch (Exception $exception) {
            throw $this->determineClientException($exception);
        }

        $response_content = $response->getBody()->getContents();
        $response_data = $this->parseResponse($response_content);

        if ($response_data->returncode === null) {
            throw new FidelyNetServiceException(Messages::UNKNOWN_ERROR, $response_content);
        }

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
     * Parses the service response to a common DTO format.
     *
     * @param string $response_content
     *
     * @throws UnknownProperties
     *
     * @return ApiResponse
     */
    protected function parseResponse(string $response_content): ApiResponse
    {
        $parsed_response = json_decode($response_content, true);

        return new ApiResponse($parsed_response);
    }

    /**
     * Determines the error returned by the service.
     *
     * @param $returnCode
     * @param string $responseBody
     *
     * @return Exception
     */
    protected function determineApiError($returnCode, string $responseBody = ''): Exception
    {
        return match ($returnCode) {
            '9999'  => new FidelyNetServiceException(Messages::SERVICE_BAD_REQUEST, $responseBody, 9999),
            50      => new CustomerNotFoundException(),
            240     => new MissingRequiredFieldsException(Messages::SERVICE_MISSING_REQUIRED_FIELDS),
            79      => new UnauthorizedActionException(Messages::UNAUTHORIZED_ACTION),
            110     => new GeoLevelNotFoundException(Messages::GEO_LEVEL_NOT_FOUND),
            default => new FidelyNetServiceException(Messages::SERVICE_RETURNED_ERROR_CODE."$returnCode: ".ApiMessages::CODES[$returnCode], $responseBody, $returnCode)
        };
    }

    /**
     * Determines the exception thrown by Guzzle client.
     *
     * @param $exception
     *
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

    public function useEntryPoint(string $entryPoint): self
    {
        $this->baseURI = $entryPoint;

        return $this;
    }
}
