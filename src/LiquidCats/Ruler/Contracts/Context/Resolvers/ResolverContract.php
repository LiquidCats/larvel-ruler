<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Contracts\Context\Resolvers;

/**
 * Interface ResolverContract.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
interface ResolverContract
{
    public function value();

    public function name(): string;
}
