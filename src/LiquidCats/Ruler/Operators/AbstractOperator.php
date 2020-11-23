<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Operators;

use Psr\Log\LoggerInterface;
use LiquidCats\Ruler\Contracts\CacherContract;

/**
 * Class AbstractOperator.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
abstract class AbstractOperator
{
    protected LoggerInterface $logger;
    protected CacherContract $cacher;

    public function __construct(LoggerInterface $logger, CacherContract $cacher)
    {
        $this->logger = $logger;
        $this->cacher = $cacher;
    }

    abstract public function getOperator(): \Closure;

    abstract public function getName(): string;

    protected function logResult($result, array $ctx = []): void
    {
        $result = json_encode($result, JSON_THROW_ON_ERROR);
        $m = sprintf('[SECURITY.operator] Rule [%s] executed with result [%s]', $this->getName(), (string) $result ?: '0');
        $this->logger->debug($m, $ctx);
    }

    protected function wasCached(...$ctx): bool
    {
        return $this->cacher->has($this->getName(), ...$ctx);
    }

    protected function getCached(...$ctx)
    {
        $result = $this->cacher->get($this->getName(), ...$ctx);
        $m = sprintf('[SECURITY.operator] Rule [%s] was restored from cache with result [%s]', $this->getName(), (string) $result ?: '0');
        $this->logger->debug($m, $ctx);

        return $result;
    }

    protected function cacheResult($result, ...$ctx): void
    {
        $this->cacher->put($result, $this->getName(), ...$ctx);
    }
}
