<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Contracts;

use LiquidCats\Ruler\Context\ContextualAction;

/**
 * Class EnforcerContract.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
interface EnforcerContract
{
    public function check(ContextualAction $action): bool;
}
