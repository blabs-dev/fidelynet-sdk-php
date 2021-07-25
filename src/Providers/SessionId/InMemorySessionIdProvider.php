<?php


namespace Blabs\FidelyNet\Providers\SessionId;


use Blabs\FidelyNet\Contracts\SessionIdProviderContract;

/**
 * A Simple "in memory" implementation of the SessionIdProviderContract
 *
 * Class InMemorySessionIdProvider
 * @package Blabs\FidelyNet\Providers\SessionId
 */
final class InMemorySessionIdProvider implements SessionIdProviderContract
{

    /**
     * Current session id
     *
     * @var string
     */
    private $sessionId;


    /**
     * @inheritDoc
     */
    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    /**
     * @inheritDoc
     */
    public function setSessionId(string $sessionId): void
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @inheritDoc
     */
    function isSessionPersistent(): bool
    {
        return false;
    }
}
