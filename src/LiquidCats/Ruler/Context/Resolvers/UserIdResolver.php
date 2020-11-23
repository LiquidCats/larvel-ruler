<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Context\Resolvers;

use Illuminate\Contracts\Auth\Guard;

/**
 * Class UserIdResolver.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
class UserIdResolver implements \LiquidCats\Ruler\Contracts\Context\Resolvers\UserIdResolver
{
    protected Guard $guard;

    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    public function value(): int
    {
        return (int) $this->guard->id();
    }

    public function name(): string
    {
        return 'userId';
    }
}
