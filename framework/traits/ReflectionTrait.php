<?php namespace welcome\traits;

trait ReflectionTrait
{
    private static $_reflectionClass;

    /**
     * @return \ReflectionClass
     */
    final public static function getReflectionClass()
    {
        if (!self::$_reflectionClass) {
            self::$_reflectionClass = new \ReflectionClass(static::class);
        }

        return self::$_reflectionClass;
    }
}