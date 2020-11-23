<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Context\Traits;

use LiquidCats\Ruler\Context\Serializer;
use LiquidCats\Ruler\Contracts\Context\Variables\HasHash;

/**
 * Trait Hashable.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 * @mixin HasHash
 */
trait Hashable
{
    public function getHash(): string
    {
        return strtolower(
            md5(
                Serializer::serialize(
                    $this->params
                )
            )
        );
    }
}
