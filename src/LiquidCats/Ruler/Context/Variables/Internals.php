<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Context\Variables;

use stdClass;
use Illuminate\Contracts\Support\Arrayable;
use LiquidCats\Ruler\Context\Traits\Hashable;
use LiquidCats\Ruler\Contracts\Context\Variables\HasHash;
use LiquidCats\Ruler\Context\Traits\Arrayable as ArrayableTrait;
use LiquidCats\Ruler\Contracts\Context\Resolvers\ResolverContract;

/**
 * Class Internals.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
final class Internals implements HasHash, Arrayable
{
    use ArrayableTrait;
    use Hashable;

    protected stdClass $params;

    public function __construct()
    {
        $this->params = new stdClass();
    }

    public function __get(string $name)
    {
        if (property_exists($this->params, $name)) {
            return $this->parameter($name);
        }

        return null;
    }

    public function parameter($key)
    {
        return $this->params->{$key} ?? null;
    }

    public function setParameter(ResolverContract $resolver): void
    {
        $this->params->{$resolver->name()} = $resolver->value();
    }

    public function toArray()
    {
        return self::mutate($this->params, true);
    }
}
