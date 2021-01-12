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

use FriendsOfHyperf\Ssdb\SsdbManager;
use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;

class SsdbHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var ConfigInterface $config */
        $config = $container->get(ConfigInterface::class);
        $connection = $config->get('session.options.connection', 'default');
        $gcMaxLifetime = (int) $config->get('session.options.gc_maxlifetime', 1200);
        /** @var SsdbManager $manager */
        $manager = $container->get(SsdbManager::class);
        $ssdb = $manager->get($connection);

        return new SsdbHandler($ssdb, $gcMaxLifetime);
    }
}
