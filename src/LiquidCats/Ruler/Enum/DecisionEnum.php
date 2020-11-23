<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Enum;

/**
 * Class DecisionEnum.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
interface DecisionEnum
{
    public const AFFIRMATIVE = 0;   // At least one should be positive
    public const CONSENSUS = 1;     // Positive should be more rather negative
    public const UNANIMOUS = 2;     // All should be positive
}
