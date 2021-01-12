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
use Hyperf\Utils\ApplicationContext;

class SsdbFactory
{
    /**
     * @throws Exception
     * @throws Exception
     * @return Ssdb
     */
    public function __invoke()
    {
        return ApplicationContext::getContainer()->get(SsdbManager::class)->get();
    }
}
