<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *  @method string get(string $type)
 * @method static void set(string $type, string $value)
 */
abstract class BaseFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return static::class;
    }

    public static function proxy(string $class)
    {
        app()->singleton(self::getFacadeAccessor(), $class);
    }
}
