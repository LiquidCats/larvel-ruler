<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Contracts;

/**
 * Interface CacherContract.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
interface CacherContract
{
    public const DEFAULT_TTL = 60 * 60 * 24;
    public const DEFAULT_TAG = 'permissions';
    public const DEFAULT_PREFIX = 'security:permissions:decisions';

    public function put($result, ...$ctx): void;

    public function get(...$ctx);

    public function has(...$ctx): bool;

    public function flush(): void;
}
