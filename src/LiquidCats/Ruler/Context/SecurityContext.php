<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Context;

use Hoa\Ruler\Context;
use Illuminate\Contracts\Support\Arrayable;
use LiquidCats\Ruler\Context\Variables\Env;
use LiquidCats\Ruler\Context\Variables\Source;
use LiquidCats\Ruler\Context\Variables\Internals;
use LiquidCats\Ruler\Contracts\Context\Variables\HasHash;

/**
 * Class SecurityContext.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
class SecurityContext extends Context implements HasHash, Arrayable
{
    private function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    public static function make(Source $source, Internals $internals, Env $system): self
    {
        $context = new static();
        $context['source'] = $source;
        $context['internals'] = $internals;
        $context['env'] = $system;

        return $context;
    }

    public function getHash(): string
    {
        $hash = '';
        foreach ($this->_data as $item) {
            if ($item instanceof HasHash) {
                $hash .= $item->getHash();
            }
        }

        return strtolower(md5($hash));
    }

    public function toArray(): array
    {
        $source = $this->offsetGet('source')->toArray();
        $internals = $this->offsetGet('internals')->toArray();
        $env = $this->offsetGet('env')->toArray();

        return compact('source', 'internals', 'env');
    }
}
