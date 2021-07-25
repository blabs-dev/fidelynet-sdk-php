<?php


namespace Blabs\FidelyNet\Providers\SessionId;


use Blabs\FidelyNet\Contracts\SessionIdProviderContract;

final class TmpDirSessionIdProvider implements SessionIdProviderContract
{
    const TMP_FILENAME = 'FNET_session_id';

    /**
     * The file path where provider stores session id
     *
     * @var string
     */
    private $tmpFilePath;

    /**
     * TmpDirSessionIdProvider constructor.
     *
     * @param string $service_type a string used as identifier to distinguish between temporary session files
     */
    public function __construct(string $service_type = '')
    {
        $this->tmpFilePath = sys_get_temp_dir() . "/" .  self::TMP_FILENAME . '__' . $service_type;
        if (!file_exists($this->tmpFilePath)) { file_put_contents($this->tmpFilePath, "");
        }
    }

    /**
     * @inheritDoc
     */
    function setSessionId(string $sessionId): void
    {
        file_put_contents($this->tmpFilePath, $sessionId);
    }

    /**
     * @inheritDoc
     */
    function getSessionId(): ?string
    {
        return file_get_contents($this->tmpFilePath);
    }

    /**
     * @inheritDoc
     */
    function isSessionPersistent(): bool
    {
        return true;
    }

    /**
     * Returns the file path where provider stores session id
     *
     * @return string
     */
    public function getTmpFilePath(): string
    {
        return $this->tmpFilePath;
    }
}
