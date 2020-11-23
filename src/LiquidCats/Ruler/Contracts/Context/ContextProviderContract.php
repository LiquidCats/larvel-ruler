<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Contracts\Context;

use LiquidCats\Ruler\Context\SecurityContext;
use LiquidCats\Ruler\Context\ContextualAction;

/**
 * Class ContextProviderContract.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
interface ContextProviderContract
{
    public function context(ContextualAction $action): SecurityContext;
}
