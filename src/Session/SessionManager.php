<?php

namespace Blabs\FidelyNet\Session;

use Blabs\FidelyNet\Client;
use Blabs\FidelyNet\Constants\ApiActions;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\ApiSessionTypes;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Contracts\SessionIdProviderContract;
use Blabs\FidelyNet\Exceptions\FidelyNetSessionException;
use Blabs\FidelyNet\Session\LoginStrategies\BackofficeLoginStrategy;
use Blabs\FidelyNet\Session\LoginStrategies\CustomerLoginStrategy;
use Blabs\FidelyNet\Session\LoginStrategies\TerminalLoginStrategy;

final class SessionManager
{
    const MAX_SESSION_RENEW_TRIES = 2;

    /**
     * Number of times the session was renewed.
     *
     * @var int
     */
    protected $sessionRenews = 0;

    /**
     * Session ID provider class (sets and gets the session id for every request).
     *
     * @var SessionIdProviderContract
     */
    protected $sessionIdProvider;

    /**
     * Managed session's Client.
     *
     * @var Client
     */
    protected $client;

    /**
     * An array containing all credentials needed to open a session.
     *
     * @var array
     */
    private $credentials;

    /**
     * Current session type (public or private).
     *
     * @var string
     */
    private $session_type;

    /**
     * SessionManager constructor.
     *
     * @param array                     $credentials
     * @param string                    $session_type
     * @param SessionIdProviderContract $sessionIdProvider
     * @param Client                    $client
     */
    public function __construct(array $credentials, string $session_type, SessionIdProviderContract $sessionIdProvider, Client $client)
    {
        $this->client = $client;
        $this->session_type = $session_type;
        $this->sessionIdProvider = $sessionIdProvider;
        $this->credentials = $credentials;
    }

    /**
     * Return current session persistence capability.
     *
     * @return bool
     */
    public function isSessionPersistent()
    {
        return $this->sessionIdProvider->isSessionPersistent();
    }

    /**
     * Initialize a session on FNET service and store the session id.
     */
    public function initSession(): void
    {
        $this->session_type === ApiSessionTypes::PRIVATE ?
            $this->setSessionId($this->openPrivateSession())
            : $this->setSessionId($this->openPublicSession());
    }

    /**
     * Renew current session.
     *
     * @throws FidelyNetSessionException
     */
    public function renewSession(): void
    {
        $this->sessionRenews++;
        if ($this->sessionRenews == self::MAX_SESSION_RENEW_TRIES) {
            throw new FidelyNetSessionException(Messages::MAX_SESSION_RENEWS);
        }
        $this->initSession();
    }

    /**
     * Get the session id.
     */
    public function getSessionId(): ?string
    {
        return $this->sessionIdProvider->getSessionId();
    }

    /**
     * Set the current session id.
     *
     * @param string $sessionId
     *
     * @return self
     */
    public function setSessionId(string $sessionId): self
    {
        $this->sessionIdProvider->setSessionId($sessionId);

        return $this;
    }

    /**
     * Authenticates within the chosen services starting a session.
     *
     * @return string
     */
    private function openPrivateSession(): string
    {
        switch ($this->client->getServiceType()) {
        case ApiServices::BACKOFFICE:
            $login_strategy = BackofficeLoginStrategy::class;
            break;
        case ApiServices::TERMINAL:
            $login_strategy = TerminalLoginStrategy::class;
            break;
        case ApiServices::CUSTOMER:
            $login_strategy = CustomerLoginStrategy::class;
            break;
        }

        return (new $login_strategy($this->client))->startSession($this->credentials);
    }

    /**
     * Obtain a public session id to access public FNET service methods.
     *
     * @throws FidelyNetSessionException
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return string
     */
    private function openPublicSession(): string
    {
        $response = $this->client->actionRequest(ApiActions::SYNCHRO, ['kind' => 3, 'campaignid' => $this->credentials[FactoryOptions::CAMPAIGN_ID]]);

        return $response->data['session'];
    }

    /**
     * Get the current session type (private or public).
     *
     * @return string
     */
    public function getSessionType()
    {
        return $this->session_type;
    }

    /**
     * Get the number of times current session was renewed.
     *
     * @return int
     */
    public function getSessionRenews(): int
    {
        return $this->sessionRenews;
    }
}
