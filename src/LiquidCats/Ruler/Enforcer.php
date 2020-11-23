<?php

declare(strict_types=1);

namespace LiquidCats\Ruler;

use LiquidCats\Ruler\Context\ContextualAction;
use LiquidCats\Ruler\Contracts\CompilerContract;
use LiquidCats\Ruler\Contracts\EnforcerContract;
use LiquidCats\Ruler\Contracts\Context\ContextProviderContract;
use LiquidCats\Ruler\Contracts\Rules\PermissionsProviderContract;

/**
 * Class Enforcer.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
class Enforcer implements EnforcerContract
{
    protected CompilerContract $compiler;
    protected ContextProviderContract $contextProvider;
    protected PermissionsProviderContract $permissionsProvider;

    public function __construct(
        CompilerContract $compiler,
        ContextProviderContract $contextProvider,
        PermissionsProviderContract $permissionsProvider
    ) {
        $this->compiler = $compiler;
        $this->contextProvider = $contextProvider;
        $this->permissionsProvider = $permissionsProvider;
    }

    public function check(ContextualAction $action): bool
    {
        $context = $this->contextProvider->context($action);
        $permissions = $this->permissionsProvider->getPermissions($action);

        foreach ($permissions as $permission) {
            if ($this->compiler->compile($permission, $context)) {
                return true;
            }
        }

        return false;
    }
}
