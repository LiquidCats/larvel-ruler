<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Context;

use LiquidCats\Ruler\Enum\ActionEnum;

/**
 * Class Action.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
final class ContextualAction implements ActionEnum
{
    private string $action;
    private string $resource;

    public function __construct(string $resource, string $action)
    {
        assert(in_array($action, self::ALL), 'Unsupported action');
        $this->action = $action;
        $this->resource = $resource;
    }

    public static function from(string $resource, string $action = self::INDEX): self
    {
        return new static($resource, $action);
    }

    public static function index(string $resource): self
    {
        return static::from($resource, self::INDEX);
    }

    public static function show(string $resource): self
    {
        return static::from($resource, self::SHOW);
    }

    public static function update(string $resource): self
    {
        return static::from($resource, self::UPDATE);
    }

    public static function create(string $resource): self
    {
        return static::from($resource, self::CREATE);
    }

    public static function delete(string $resource): self
    {
        return static::from($resource, self::DELETE);
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getResource(): string
    {
        return $this->resource;
    }
}
