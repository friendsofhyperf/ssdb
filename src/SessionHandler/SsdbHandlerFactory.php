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

use FriendsOfHyperf\Ssdb\SsdbFactory;
use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;

class SsdbHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get(ConfigInterface::class);
        $connection = $config->get('session.options.connection');
        $gcMaxLifetime = (int) $config->get('session.options.gc_maxlifetime', 1200);
        /** @var SsdbFactory $factory */
        $factory = $container->get(SsdbFactory::class);
        $ssdb = $factory->get($connection);

        return new SsdbHandler($ssdb, $gcMaxLifetime);
    }
}
