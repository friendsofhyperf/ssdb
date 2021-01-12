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

use FriendsOfHyperf\Ssdb\SessionHandler\SsdbHandler;
use FriendsOfHyperf\Ssdb\SessionHandler\SsdbHandlerFactory;
use Huangdijia\Ssdb\Ssdb;

class ConfigProvider
{
    public function __invoke(): array
    {
        defined('BASE_PATH') or define('BASE_PATH', __DIR__);

        return [
            'dependencies' => [
                Ssdb::class => SsdbFactory::class,
                SsdbFactory::class => SsdbFactory::class,
                SsdbHandler::class => SsdbHandlerFactory::class,
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'commands' => [],
            'listeners' => [],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for SSDB.',
                    'source' => __DIR__ . '/../publish/ssdb.php',
                    'destination' => BASE_PATH . '/config/autoload/ssdb.php',
                ],
            ],
        ];
    }
}
