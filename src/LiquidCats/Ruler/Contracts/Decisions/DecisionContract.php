<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Contracts\Decisions;

/**
 * Class DecisionContaract.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
interface DecisionContract
{
    public static function process(iterable $haystack): bool;

    public static function shouldRun(int $strategy): bool;
}
