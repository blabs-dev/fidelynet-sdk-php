<?php


namespace Blabs\FidelyNet\Contracts;

/**
 * A simple wrapper to get and set the current session id.
 *
 * To let the session be persistent across multiple service requests,
 * it's possible to implement it using any storage engine (filesystem, cache, database, etc)
 *
 * Interface SessionIdProviderContract
 * @package Blabs\FidelyNet\Contracts
 */
interface SessionIdProviderContract
{
    /**
     * Sets the current session id.
     *
     * @param string $sessionId
     */
    function setSessionId(string $sessionId) :void;

    /**
     * Get the current session id.
     *
     * @return string|null
     */
    function getSessionId() :?string;

    /**
     * Returns the persistence capability of the implementation
     *
     * @return bool
     */
    function isSessionPersistent() :bool;
}
