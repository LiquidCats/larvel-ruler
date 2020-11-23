<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Decisions;

use LiquidCats\Ruler\Enum\DecisionEnum;
use LiquidCats\Ruler\Contracts\Decisions\DecisionContract;

/**
 * Class Affirmative
 * At least one should be positive.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
class Affirmative implements DecisionContract, DecisionEnum
{
    public static function process(iterable $haystack): bool
    {
        foreach ($haystack as $decision) {
            if (true === $decision) {
                return true;
            }
        }

        return false;
    }

    public static function shouldRun(int $strategy): bool
    {
        return self::AFFIRMATIVE === $strategy;
    }
}
