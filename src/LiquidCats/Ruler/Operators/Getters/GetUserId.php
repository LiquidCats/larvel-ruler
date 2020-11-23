<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Operators\Getters;

use LiquidCats\Ruler\Operators\AbstractOperator;
use LiquidCats\Ruler\Context\Variables\Internals;

/**
 * Class GetUserId.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
class GetUserId extends AbstractOperator
{
    public function getOperator(): \Closure
    {
        return function (Internals $internals) {
            if ($this->wasCached(...func_get_args())) {
                return $this->getCached(...func_get_args());
            }
            $result = (int) $internals->userId;

            $this->cacheResult($result, ...func_get_args());
            $this->logResult($result, ['internals' => $internals->toArray()]);

            return $result;
        };
    }

    public function getName(): string
    {
        return 'GetUserId';
    }
}
