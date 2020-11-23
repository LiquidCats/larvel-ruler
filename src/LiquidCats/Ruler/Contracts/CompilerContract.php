<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Contracts;

use LiquidCats\Ruler\Context\SecurityContext;
use LiquidCats\Ruler\Contracts\Rules\PermissionContract;

/**
 * Class CompilerCotract.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
interface CompilerContract
{
    public function compile(PermissionContract $permission, SecurityContext $context): bool;
}
