<?php

declare(strict_types=1);

namespace LiquidCats\Ruler;

use LiquidCats\Ruler\Contracts\CacherContract;
use Illuminate\Contracts\Redis\Factory as RedisFactory;
use Illuminate\Contracts\Config\Repository as ConfigRepo;
use LiquidCats\Ruler\Contracts\Context\Variables\HasHash;
use Illuminate\Redis\Connections\Connection as RedisConnection;

/**
 * Class Cacher.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
class Cacher implements CacherContract
{
    protected ConfigRepo $config;
    protected RedisConnection $redis;

    public function __construct(ConfigRepo $config, RedisFactory $redis)
    {
        $this->config = $config;
        $this->redis = $redis->connection('simple');
    }

    public function put($result, ...$ctx): void
    {
        $ttl = $this->config->get('security.cache.timeout', self::DEFAULT_TTL);
        $key = $this->calculateKey(...func_get_args());
        $this->redis->set($key, $this->encode($result));
        $this->redis->expire($key, $ttl);
    }

    public function get(...$ctx)
    {
        return $this->decode($this->redis->get($this->calculateKey(...func_get_args())));
    }

    public function has(...$ctx): bool
    {
        return 1 === $this->redis->exists($this->calculateKey(...func_get_args()));
    }

    public function calculateKey(...$ctx): string
    {
        $prefix = rtrim($this->config->get('security.cache.prefix', self::DEFAULT_PREFIX), ':');
        $base = '';

        foreach ($ctx as $item) {
            if ($item instanceof HasHash) {
                $base .= $item->getHash();
            }
            if (is_numeric($item)) {
                $base .= md5((string) $item);
            }
            if (is_string($item)) {
                $base .= md5($item);
            }
            if (is_array($item) || is_object($item)) {
                $base .= json_encode($item, JSON_THROW_ON_ERROR);
            }
        }

        return strtolower(sprintf('%s:%s', $prefix, md5($base)));
    }

    public function flush(): void
    {
        $prefix = $prefix = rtrim($this->config->get('security.cache.prefix', self::DEFAULT_PREFIX), ':');
        $keys = $this->redis->keys($prefix.'*');

        foreach ($keys as $key) {
            $this->redis->del($key);
        }
    }

    protected function decode($raw)
    {
        return json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
    }

    protected function encode($data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR);
    }
}
