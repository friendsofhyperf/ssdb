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
use SessionHandlerInterface;

class SsdbHandler implements SessionHandlerInterface
{
    public function __construct(protected $ssdb, protected int $gcMaxLifeTime)
    {
    }

    /**
     * Close the session.
     *
     * @see https://php.net/manual/en/sessionhandlerinterface.close.php
     * @return bool
     */
    public function close()
    {
        return true;
    }

    /**
     * Destroy a session.
     *
     * @see https://php.net/manual/en/sessionhandlerinterface.destroy.php
     * @param string $session_id the session ID being destroyed
     * @return bool
     */
    public function destroy($session_id)
    {
        $this->ssdb->del($session_id);
        return true;
    }

    /**
     * Cleanup old sessions.
     *
     * @see https://php.net/manual/en/sessionhandlerinterface.gc.php
     * @param int $maxlifetime
     * @return bool
     */
    public function gc($maxlifetime)
    {
        return true;
    }

    /**
     * Initialize session.
     *
     * @see https://php.net/manual/en/sessionhandlerinterface.open.php
     * @param string $save_path the path where to store/retrieve the session
     * @param string $name the session name
     * @return bool
     */
    public function open($save_path, $name)
    {
        return true;
    }

    /**
     * Read session data.
     *
     * @see https://php.net/manual/en/sessionhandlerinterface.read.php
     * @param string $session_id the session id to read data for
     * @return string
     */
    public function read($session_id)
    {
        return $this->ssdb->get($session_id)->data ?: '';
    }

    /**
     * Write session data.
     *
     * @see https://php.net/manual/en/sessionhandlerinterface.write.php
     * @param string $session_id the session id
     * @param string $session_data
     * @return bool
     */
    public function write($session_id, $session_data)
    {
        return (bool) $this->ssdb->setx($session_id, $session_data, (int) $this->gcMaxLifeTime);
    }
}
