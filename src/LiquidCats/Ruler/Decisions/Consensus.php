<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Decisions;

use LiquidCats\Ruler\Enum\DecisionEnum;
use LiquidCats\Ruler\Contracts\Decisions\DecisionContract;

/**
 * Class Consensus
 * Positive should be more rather negative.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
class Consensus implements DecisionContract, DecisionEnum
{
    public static function process(iterable $haystack): bool
    {
        $pCount = 0;
        $nCount = 0;
        foreach ($haystack as $decision) {
            if (true === $decision) {
                ++$pCount;
            }
            if (false === $decision) {
                ++$nCount;
            }
        }

        return $pCount > $nCount;
    }

    public static function shouldRun(int $strategy): bool
    {
        return self::CONSENSUS === $strategy;
    }
}
