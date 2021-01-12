<?php

declare(strict_types=1);
/**
 * This file is part of friendsofhyperf/ssdb.
 *
 * @link     https://github.com/friendsofhyperf/ssdb
 * @document https://github.com/friendsofhyperf/ssdb/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\Ssdb;

use Exception;
use Huangdijia\Ssdb\Ssdb;
use Hyperf\Contract\ConfigInterface;

class SsdbManager
{
    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var Ssdb[]
     */
    protected $connections = [];

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @throws Exception
     * @throws Exception
     * @return Ssdb
     */
    public function get(string $connection = 'default')
    {
        if (! isset($this->connections[$connection])) {
            if (! $this->config->get('ssdb.' . $connection)) {
                throw new Exception(sprintf('config ssdb.%s undefined', $connection), 1);
            }

            $host = $this->config->get(sprintf('ssdb.%s.host', $connection));
            $port = (int) $this->config->get(sprintf('ssdb.%s.port', $connection));
            $timeout = (int) $this->config->get(sprintf('ssdb.%s.timeout', $connection));

            $this->connections[$connection] = tap(new Ssdb($host, $port, $timeout), function ($ssdb) {
                $ssdb->easy();
            });
        }

        return  $this->connections[$connection];
    }
}
