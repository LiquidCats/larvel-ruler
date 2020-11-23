<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Context\Variables;

use stdClass;
use Illuminate\Contracts\Support\Arrayable;
use LiquidCats\Ruler\Context\Traits\Hashable;
use LiquidCats\Ruler\Context\ContextualAction;
use LiquidCats\Ruler\Contracts\Context\Variables\HasHash;
use LiquidCats\Ruler\Context\Traits\Arrayable as ArrayableTrait;

/**
 * Class System.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 *
 * @property stdClass $contextualAction
 */
final class Env implements HasHash, Arrayable
{
    use ArrayableTrait;
    use Hashable;

    protected stdClass $params;

    public function __construct()
    {
        $this->params = new stdClass();
    }

    public function __get($name)
    {
        return $this->getParameter($name);
    }

    public function setParameter(string $key, $value): void
    {
        $this->params->{$key} = $value;
    }

    public function getParameter(string $key)
    {
        return $this->params->{$key} ?? null;
    }

    public function setContextualAction(ContextualAction $action): void
    {
        $context = new stdClass();
        $context->{'context'} = $action->getResource();
        $context->{'action'} = $action->getAction();
        $this->setParameter('contextualAction', $context);
    }
}
