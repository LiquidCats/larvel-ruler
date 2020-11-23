<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Context;

use LiquidCats\Ruler\Context\Variables\Env;
use LiquidCats\Ruler\Context\Variables\Source;
use LiquidCats\Ruler\Context\Variables\Internals;
use LiquidCats\Ruler\Contracts\Context\ContextProviderContract;

/**
 * Class ContextProvider.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
class ContextProvider implements ContextProviderContract
{
    protected Source $source;
    protected Internals $internals;
    protected Env $system;

    public function __construct(Source $source, Internals $internals, Env $system)
    {
        $this->source = $source;
        $this->internals = $internals;
        $this->system = $system;
    }

    public function context(ContextualAction $action): SecurityContext
    {
        $this->system->setContextualAction($action);

        return SecurityContext::make(
            $this->source,
            $this->internals,
            $this->system
        );
    }
}
