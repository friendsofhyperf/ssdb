<?php

declare(strict_types=1);
/**
 * This file is part of friendsofhyperf/ssdb.
 *
 * @link     https://github.com/friendsofhyperf/ssdb
 * @document https://github.com/friendsofhyperf/ssdb/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
return [
    'default' => [
        'host' => env('SSDB_HOST', '127.0.0.1'),
        'port' => (int) env('SSDB_PORT', 8888),
        'timeout' => (int) env('SSDB_TIMEOUT', 3000),
    ],
];
