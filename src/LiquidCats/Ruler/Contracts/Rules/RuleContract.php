<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Contracts\Rules;

/**
 * Interface RuleContract.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
interface RuleContract
{
    public function getName(): string;

    public function getDefinition(): string;
}
