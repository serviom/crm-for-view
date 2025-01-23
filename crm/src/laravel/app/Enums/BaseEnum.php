<?php
namespace App\Enums;

use ReflectionClass;

abstract class BaseEnum
{
    /**
     * Returns class constant values
     * @return array
     */
    public static function toArray(): array
    {
        $class = new ReflectionClass(static::class);

        return $class->getConstants();
    }
}
