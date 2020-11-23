<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Contracts;

/**
 * Interface AuthorizerContract.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
interface AuthorizerContract
{
    public function authorise(string $resource, string $action): bool;
}
