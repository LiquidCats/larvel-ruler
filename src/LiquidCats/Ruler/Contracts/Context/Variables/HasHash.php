<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Contracts\Context\Variables;

/**
 * Class Cachable.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
interface HasHash
{
    public function getHash(): string;
}
