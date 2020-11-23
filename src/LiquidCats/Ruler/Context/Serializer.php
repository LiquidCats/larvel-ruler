<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Context;

/**
 * Class Serializer.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
class Serializer
{
    public static function serialize($data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    public static function unserialize($encoded, bool $toArray = true)
    {
        return json_decode($encoded, $toArray, 512, JSON_THROW_ON_ERROR);
    }
}
