<?php

declare(strict_types=1);

namespace LiquidCats\Ruler;

use LiquidCats\Ruler\Context\ContextualAction;
use LiquidCats\Ruler\Contracts\EnforcerContract;
use LiquidCats\Ruler\Contracts\AuthorizerContract;
use Illuminate\Contracts\Config\Repository as ConfigRepo;

/**
 * Class Authorizer.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
class Authorizer implements AuthorizerContract
{
    protected EnforcerContract $enforcer;

    protected ConfigRepo $config;

    public function __construct(
        EnforcerContract $enforcer,
        ConfigRepo $config
    ) {
        $this->enforcer = $enforcer;
        $this->config = $config;
    }

    public function authorise(string $resource, string $action): bool
    {
        if ($this->isDisabled()) {
            return true;
        }
        $contextualAction = ContextualAction::from($resource, $action);

        return $this->enforcer->check($contextualAction);
    }

    protected function isDisabled(): bool
    {
        return $this->config->get('security.disabled', true);
    }
}
