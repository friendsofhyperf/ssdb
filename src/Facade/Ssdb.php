<?php

declare(strict_types=1);
/**
 * This file is part of friendsofhyperf/ssdb.
 *
 * @link     https://github.com/friendsofhyperf/ssdb
 * @document https://github.com/friendsofhyperf/ssdb/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\Ssdb\Facade;

use FriendsOfHyperf\Ssdb\SsdbManager;
use Hyperf\Utils\ApplicationContext;
use TypeError;

/**
 * @method static void auth($password)
 * @method static \Huangdijia\Ssdb\Response set($key, $value)
 * @method static \Huangdijia\Ssdb\Response setx($key, $value, $ttl)
 * @method static \Huangdijia\Ssdb\Response setnx($key, $value)
 * @method static \Huangdijia\Ssdb\Response expire($key, $ttl)
 * @method static \Huangdijia\Ssdb\Response ttl($key)
 * @method static \Huangdijia\Ssdb\Response get($key)
 * @method static \Huangdijia\Ssdb\Response getset($key, $value)
 * @method static \Huangdijia\Ssdb\Response del($key)
 * @method static \Huangdijia\Ssdb\Response incr($key, $num)
 * @method static \Huangdijia\Ssdb\Response exists($key)
 * @method static \Huangdijia\Ssdb\Response getbit($key, int $offset)
 * @method static \Huangdijia\Ssdb\Response setbit($key, int $offset, int $val)
 * @method static \Huangdijia\Ssdb\Response bitcount($key, $start, $end)
 * @method static \Huangdijia\Ssdb\Response substr($key, $start, $size)
 * @method static \Huangdijia\Ssdb\Response strlen($key)
 * @method static \Huangdijia\Ssdb\Response keys($keyStart, $keyEnd, $limit)
 * @method static \Huangdijia\Ssdb\Response rkeys($keyStart, $keyEnd, $limit)
 * @method static \Huangdijia\Ssdb\Response scan($keyStart, $keyEnd, $limit)
 * @method static \Huangdijia\Ssdb\Response rscan($keyStart, $keyEnd, $limit)
 * @method static \Huangdijia\Ssdb\Response multi_set(array $kvs)
 * @method static \Huangdijia\Ssdb\Response multi_get(array $keys)
 * @method static \Huangdijia\Ssdb\Response multi_del(array $keys)
 * @method static \Huangdijia\Ssdb\Response hset($name, $key, $value)
 * @method static \Huangdijia\Ssdb\Response hget($name, $key)
 * @method static \Huangdijia\Ssdb\Response hdel($name, $key)
 * @method static \Huangdijia\Ssdb\Response hincr($name, $key, int $num)
 * @method static \Huangdijia\Ssdb\Response hexists($name, $key)
 * @method static \Huangdijia\Ssdb\Response hsize($name)
 * @method static \Huangdijia\Ssdb\Response hlist($nameStart, $nameEnd, int $limit)
 * @method static \Huangdijia\Ssdb\Response hrlist($nameStart, $nameEnd, int $limit)
 * @method static \Huangdijia\Ssdb\Response hkeys($name, $keyStart, $keyEnd, int $limit)
 * @method static \Huangdijia\Ssdb\Response hgetall($name)
 * @method static \Huangdijia\Ssdb\Response hscan($name, $keyStart, $keyEnd, int $limit)
 * @method static \Huangdijia\Ssdb\Response hrscan($name, $keyStart, $keyEnd, int $limit)
 * @method static \Huangdijia\Ssdb\Response hclear($name)
 * @method static \Huangdijia\Ssdb\Response multi_hset($name, array $kvs)
 * @method static \Huangdijia\Ssdb\Response multi_hget($name, array $keys)
 * @method static \Huangdijia\Ssdb\Response multi_hdel($name, array $keys)
 * @method static \Huangdijia\Ssdb\Response zset($name, $key, int $score)
 * @method static \Huangdijia\Ssdb\Response zget($name, $key)
 * @method static \Huangdijia\Ssdb\Response zdel($name, $key)
 * @method static \Huangdijia\Ssdb\Response zincr($name, $key, int $num)
 * @method static \Huangdijia\Ssdb\Response zsize($name, $key)
 * @method static \Huangdijia\Ssdb\Response zlist($nameStart, $nameEnd, $limit)
 * @method static \Huangdijia\Ssdb\Response zrlist($nameStart, $nameEnd, $limit)
 * @method static \Huangdijia\Ssdb\Response zexists($name, $key)
 * @method static \Huangdijia\Ssdb\Response zkeys($name, $keyStart, $scoreStart, $scoreEnd, $limit)
 * @method static \Huangdijia\Ssdb\Response zscan($name, $keyStart, $scoreStart, $scoreEnd, $limit)
 * @method static \Huangdijia\Ssdb\Response zrscan($name, $keyStart, $scoreStart, $scoreEnd, $limit)
 * @method static \Huangdijia\Ssdb\Response zrank($name, $key)
 * @method static \Huangdijia\Ssdb\Response zrrank($name, $key)
 * @method static \Huangdijia\Ssdb\Response zrange($name, int $offset, int $limit)
 * @method static \Huangdijia\Ssdb\Response zrrange($name, int $offset, int $limit)
 * @method static \Huangdijia\Ssdb\Response zclear($name)
 * @method static \Huangdijia\Ssdb\Response zcount($name, int $scoreStart, int $scoreEnd)
 * @method static \Huangdijia\Ssdb\Response zsum($name, int $scoreStart, int $scoreEnd)
 * @method static \Huangdijia\Ssdb\Response zavg($name, int $scoreStart, int $scoreEnd)
 * @method static \Huangdijia\Ssdb\Response zremrangebyrank($name, $start, $end)
 * @method static \Huangdijia\Ssdb\Response zremrangebyscore($name, $start, $end)
 * @method static \Huangdijia\Ssdb\Response zpop_front($name, $limit)
 * @method static \Huangdijia\Ssdb\Response zpop_back($name, $limit)
 * @method static \Huangdijia\Ssdb\Response multi_zset($name, array $kvs)
 * @method static \Huangdijia\Ssdb\Response multi_zget($name, array $keys)
 * @method static \Huangdijia\Ssdb\Response multi_zdel($name, array $keys)
 * @method static \Huangdijia\Ssdb\Response qsize($name)
 * @method static \Huangdijia\Ssdb\Response qlist($nameStart, $nameEnd, int $limit)
 * @method static \Huangdijia\Ssdb\Response qrlist($nameStart, $nameEnd, int $limit)
 * @method static \Huangdijia\Ssdb\Response qclear($name)
 * @method static \Huangdijia\Ssdb\Response qfront($name)
 * @method static \Huangdijia\Ssdb\Response qback($name)
 * @method static \Huangdijia\Ssdb\Response qget($name, int $index)
 * @method static \Huangdijia\Ssdb\Response qset($name, int $index, $val)
 * @method static \Huangdijia\Ssdb\Response qrange($name, int $offset, int $limit)
 * @method static \Huangdijia\Ssdb\Response qslice($name, $start, $end)
 * @method static \Huangdijia\Ssdb\Response qpush($name, $item)
 * @method static \Huangdijia\Ssdb\Response qpush_front($name, $item)
 * @method static \Huangdijia\Ssdb\Response qpush_back($name, $item)
 * @method static \Huangdijia\Ssdb\Response qpop($name, int $size)
 * @method static \Huangdijia\Ssdb\Response qpop_front($name, int $size)
 * @method static \Huangdijia\Ssdb\Response qpop_back($name, int $size)
 * @method static \Huangdijia\Ssdb\Response qtrim_front($name, int $size)
 * @method static \Huangdijia\Ssdb\Response qtrim_back($name, int $size)
 * @method static \Huangdijia\Ssdb\Ssdb batch()
 * @method static array exec()
 * @method static \Huangdijia\Ssdb\Response dbsize()
 * @method static bool|array info($opt)
 */
class Ssdb
{
    public static function __callStatic($name, $arguments)
    {
        return self::connection()->{$name}(...$arguments);
    }

    /**
     * @param string $connection
     * @throws TypeError
     * @return \Huangdijia\Ssdb\Ssdb
     */
    public static function connection($connection = 'default')
    {
        return ApplicationContext::getContainer()->get(SsdbManager::class)->get($connection);
    }
}
