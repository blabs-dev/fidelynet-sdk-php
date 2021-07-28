<?php

namespace Blabs\FidelyNet\Services;

use Blabs\FidelyNet\Client;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Exceptions\FidelyNetSessionException;
use Blabs\FidelyNet\Responses\ApiResponse;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

abstract class ServiceAbstract
{
    /**
     * Service's Client instance.
     *
     * @var Client
     */
    protected Client $client;

    /**
     * Service type (backoffice, customer or terminal).
     *
     * @var string
     */
    public string $service_type;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Calls an action on the service using the instanced Client.
     *
     * @param string $action
     * @param array $parameters
     *
     * @return ApiResponse
     * @throws FidelyNetServiceException
     * @throws FidelyNetSessionException
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function callAction(string $action, array $parameters): ApiResponse
    {
        if (!in_array($action, ApiServices::SUPPORTED_ACTIONS[$this->service_type])) {
            throw new FidelyNetServiceException(Messages::UNSUPPORTED_ACTION);
        }

        return $this->client->actionRequest($action, $parameters);
    }

    /**
     * Open a session in the current service.
     */
    public function initSession(): void
    {
        $this->client->initSession();
    }

    /**
     * Get the current session id.
     *
     * @return string|null
     */
    public function getSessionId(): ?string
    {
        return $this->client->getSessionId();
    }

    /**
     * Get number of sessions opened by this instance.
     *
     * @return int
     */
    public function getSessionRenews(): int
    {
        return $this->client->getSessionRenews();
    }

    /**
     * Returns true if requests are made in FNET demo environment.
     *
     * @return bool
     */
    public function isDemoMode(): bool
    {
        return $this->client->isDemoMode();
    }

    /**
     * Returns if the "driver" for the current session managers persists the id across requests.
     *
     * @return bool
     */
    public function isSessionPersistent(): bool
    {
        return $this->client->isSessionPersistent();
    }

    /**
     * Returns the set of default parameters used for service requests on this instance.
     *
     * @return array
     */
    public function getDefaultParameters(): array
    {
        return $this->client->getDefaultParameters();
    }

    /**
     * Returns number of requests made by this instance.
     *
     * @return int
     */
    public function getRequestCount(): int
    {
        return $this->client->getRequestCount();
    }

    /**
     * Returns session type of current instance.
     *
     * @return string
     */
    public function getSessionType(): string
    {
        return $this->client->getSessionType();
    }
}
