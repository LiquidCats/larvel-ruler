<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Operators\Getters;

use LiquidCats\Ruler\Context\Variables\Source;
use LiquidCats\Ruler\Operators\AbstractOperator;

/**
 * Class GetSourceKey.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
class GetKey extends AbstractOperator
{
    public function getOperator(): \Closure
    {
        return static function (Source $source, string $key = 'id') {
            $s = $source->toArray();

            return $s->router->{$key}
                ?? $s->request->{$key}
                ?? $s->mixins->{$key}
                ?? null;
        };
    }

    public function getName(): string
    {
        return 'GetKey';
    }
}
