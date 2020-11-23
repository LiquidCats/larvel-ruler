<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Decisions;

use LiquidCats\Ruler\Enum\DecisionEnum;
use LiquidCats\Ruler\Contracts\Decisions\DecisionContract;

/**
 * Class Unanimous
 * All should be positive.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
class Unanimous implements DecisionContract, DecisionEnum
{
    public static function process(iterable $haystack): bool
    {
        $isOK = false;
        foreach ($haystack as $decision) {
            if (false === $decision) {
                return false;
            }
            $isOK = true;
        }

        return $isOK;
    }

    public static function shouldRun(int $strategy): bool
    {
        return self::UNANIMOUS === $strategy;
    }
}
