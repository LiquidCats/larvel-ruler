<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Contracts\Rules;

use LiquidCats\Ruler\Contracts\Context\Variables\HasHash;

/**
 * Class PermissionContracts.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
interface PermissionContract extends HasHash
{
    public function getStrategy(): int;

    /**
     * @return RuleContract[]
     */
    public function getRules(): iterable;

    public function getName(): string;
}
