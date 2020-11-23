<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Context\Traits;

use LiquidCats\Ruler\Context\Serializer;

/**
 * Trait Arrayable.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
trait Arrayable
{
    public function toArray(): array
    {
        return Serializer::unserialize(Serializer::serialize($this->params), true);
    }
}
