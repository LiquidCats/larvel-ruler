<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Context\Variables;

use stdClass;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Contracts\Support\Arrayable;
use LiquidCats\Ruler\Context\Traits\Hashable;
use LiquidCats\Ruler\Contracts\Context\Variables\HasHash;
use LiquidCats\Ruler\Context\Traits\Arrayable as ArrayableTrait;

/**
 * Class Source.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 *
 * @property stdClass $router
 * @property stdClass $request
 * @property stdClass $mixins
 */
final class Source implements HasHash, Arrayable
{
    use ArrayableTrait;
    use Hashable;

    public const REQUEST = 'request';
    public const ROUTER = 'router';
    public const MIXINS = 'mixins';

    public const ACCESS_ALLOWED = [
        self::REQUEST,
        self::ROUTER,
        self::MIXINS,
    ];

    protected stdClass $params;

    public function __construct(stdClass $params)
    {
        $this->params = $params;
    }

    public function __get(string $name)
    {
        if (in_array($name, self::ACCESS_ALLOWED, true)) {
            return $this->{$name}();
        }

        return null;
    }

    public static function build(Request $request, array $mixin = []): self
    {
        $params = new stdClass();
        $params->{self::ROUTER} = self::buildRouter($request);
        $params->{self::REQUEST} = self::buildRequest($request);
        $params->{self::MIXINS} = self::buildMixin($request, $mixin);

        return new static($params);
    }

    public function request(): stdClass
    {
        return $this->params->{self::REQUEST} ?? new stdClass();
    }

    public function router(): stdClass
    {
        return $this->params->{self::ROUTER} ?? new stdClass();
    }

    public function mixins(): stdClass
    {
        return $this->params->{self::MIXINS} ?? new stdClass();
    }

    public function toArray()
    {
        return self::mutate($this->params, true);
    }

    protected static function buildRouter(Request $request): stdClass
    {
        $route = $request->route();
        if (null === $route) {
            return new stdClass();
        }

        return (object) static::mutate($route->parameters(), false);
    }

    protected static function buildRequest(Request $request): stdClass
    {
        return (object) static::mutate($request->all(), false);
    }

    protected static function buildMixin(Request $request, array $mixin): stdClass
    {
        return (object) static::mutate(array_merge($request->header(), $mixin), false);
    }
}
