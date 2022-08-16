<?php

declare(strict_types=1);
/**
 * This file is part of friendsofhyperf/ssdb.
 *
 * @link     https://github.com/friendsofhyperf/ssdb
 * @document https://github.com/friendsofhyperf/ssdb/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\Ssdb\SessionHandler;

use Huangdijia\Ssdb\Ssdb;
use ReturnTypeWillChange;
use SessionHandlerInterface;

class SsdbHandler implements SessionHandlerInterface
{
    public function __construct(protected Ssdb $ssdb, protected int $gcMaxLifeTime)
    {
    }

    /**
     * Close the session.
     *
     * @see https://php.net/manual/en/sessionhandlerinterface.close.php
     */
    public function close(): bool
    {
        return true;
    }

    /**
     * Destroy a session.
     *
     * @see https://php.net/manual/en/sessionhandlerinterface.destroy.php
     * @param string $session_id the session ID being destroyed
     */
    public function destroy($session_id): bool
    {
        $this->ssdb->del($session_id);
        return true;
    }

    /**
     * Cleanup old sessions.
     *
     * @see https://php.net/manual/en/sessionhandlerinterface.gc.php
     * @param int $maxlifetime
     */
    #[ReturnTypeWillChange]
    public function gc($maxlifetime): bool
    {
        return true;
    }

    /**
     * Initialize session.
     *
     * @see https://php.net/manual/en/sessionhandlerinterface.open.php
     * @param string $save_path the path where to store/retrieve the session
     * @param string $name the session name
     */
    public function open($save_path, $name): bool
    {
        return true;
    }

    /**
     * Read session data.
     *
     * @see https://php.net/manual/en/sessionhandlerinterface.read.php
     * @param string $session_id the session id to read data for
     */
    public function read($session_id): string|false
    {
        return $this->ssdb->get($session_id)->data ?: '';
    }

    /**
     * Write session data.
     *
     * @see https://php.net/manual/en/sessionhandlerinterface.write.php
     * @param string $session_id the session id
     * @param string $session_data
     */
    public function write($session_id, $session_data): bool
    {
        return (bool) $this->ssdb->setx($session_id, $session_data, (int) $this->gcMaxLifeTime);
    }
}
