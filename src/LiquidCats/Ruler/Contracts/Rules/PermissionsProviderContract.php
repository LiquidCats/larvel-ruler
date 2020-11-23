<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Contracts\Rules;

use LiquidCats\Ruler\Context\ContextualAction;

/**
 * Class RulesPrivderContract.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
interface PermissionsProviderContract
{
    /**
     * @return PermissionContract[]
     */
    public function getPermissions(ContextualAction $action): iterable;
}
