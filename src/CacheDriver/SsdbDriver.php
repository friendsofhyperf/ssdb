<?php

declare(strict_types=1);
/**
 * This file is part of friendsofhyperf/ssdb.
 *
 * @link     https://github.com/friendsofhyperf/ssdb
 * @document https://github.com/friendsofhyperf/ssdb/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\Ssdb\CacheDriver;

use FriendsOfHyperf\Ssdb\SsdbManager;
use Huangdijia\Ssdb\Ssdb;
use Hyperf\Cache\Driver\Driver;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;

class SsdbDriver extends Driver
{
    protected Ssdb $ssdb;

    public function __construct(ContainerInterface $container, array $config = [])
    {
        parent::__construct($container, $config);

        /** @var SsdbManager $manager */
        $manager = $container->get(SsdbManager::class);

        $this->ssdb = $manager->get($config['pool'] ?? 'default');
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $response = $this->ssdb->get($this->getCacheKey($key));

        if (! $response->ok()) {
            return $default;
        }

        return $this->packer->unpack($response->data);
    }

    public function fetch(string $key, $default = null): array
    {
        $response = $this->ssdb->get($this->getCacheKey($key));

        if (! $response->ok()) {
            return [false, $default];
        }

        return [true, $this->packer->unpack($response->data)];
    }

    public function set(string $key, mixed $value, null|int|\DateInterval $ttl = null): bool
    {
        $seconds = $this->secondsUntil($ttl);
        $value = $this->packer->pack($value);

        if ($seconds > 0) {
            return $this->ssdb->setx($this->getCacheKey($key), $value, $seconds)->ok();
        }

        return $this->ssdb->set($this->getCacheKey($key), $value)->ok();
    }

    public function delete(string $key): bool
    {
        return $this->ssdb->del($this->getCacheKey($key))->ok();
    }

    public function clearPrefix(string $prefix): bool
    {
        $iterator = null;

        while (true) {
            $keys = $this->ssdb->scan($this->getCacheKey($prefix), '', 10000);

            if (! empty($keys)) {
                $this->ssdb->multi_del($keys);
            }

            if (empty($iterator)) {
                break;
            }
        }

        return true;
    }

    public function clear(): bool
    {
        return $this->clearPrefix('');
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $cacheKeys = array_map(fn ($key) => $this->getCacheKey($key), $keys);

        $values = $this->ssdb->multi_get($cacheKeys)->data;
        $result = [];

        foreach ($keys as $i => $key) {
            $result[$key] = $values[$i] === false ? $default : $this->packer->unpack($values[$i]);
        }

        return $result;
    }

    public function setMultiple(iterable $values, null|int|\DateInterval $ttl = null): bool
    {
        if (! is_array($values)) {
            throw new InvalidArgumentException('The values is invalid!');
        }

        $cacheKeys = [];
        foreach ($values as $key => $value) {
            $cacheKeys[$this->getCacheKey($key)] = $this->packer->pack($value);
        }

        $seconds = $this->secondsUntil($ttl);

        if ($seconds > 0) {
            foreach ($cacheKeys as $key => $value) {
                $this->ssdb->setx($key, $value, $seconds);
            }

            return true;
        }

        return $this->ssdb->multi_set($cacheKeys)->ok();
    }

    public function deleteMultiple(iterable $keys): bool
    {
        $cacheKeys = array_map(fn ($key) => $this->getCacheKey($key), $keys);

        return $this->ssdb->multi_del($cacheKeys)->ok();
    }

    public function has(string $key): bool
    {
        return $this->ssdb->exists($this->getCacheKey($key))->ok();
    }
}
