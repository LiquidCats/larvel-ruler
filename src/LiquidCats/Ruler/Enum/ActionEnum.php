<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Enum;

/**
 * Class ActionEnum.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
interface ActionEnum
{
    public const INDEX = 'index';
    public const SHOW = 'show';
    public const UPDATE = 'update';
    public const CREATE = 'create';
    public const DELETE = 'delete';

    public const ALL = [
        self::INDEX,
        self::SHOW,
        self::UPDATE,
        self::CREATE,
        self::DELETE,
    ];
}
