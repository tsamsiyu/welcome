<?php namespace welcome\collections;


use welcome\traits\ReflectionTrait;

class Enum implements IEnumerable
{
    use ReflectionTrait;

    private static $_constantsList;


    final private function __construct(){}

    /**
     * @return array
     */
    final public static function getList()
    {
        if (!self::$_constantsList) {
            self::$_constantsList = self::getReflectionClass()->getConstants();
        }

        $res = self::$_constantsList;
        foreach (static::getExcluded() as $item) {
            if (isset($res[$item])) {
                unset($res[$item]);
            }
        }

        return $res;
    }

    public static function getExcluded()
    {
        return [];
    }

    public static function getExcludedList()
    {
        $res = [];
        foreach (static::getExcluded() as $item) {
            $res[$item] = self::getReflectionClass()->getConstant($item);
        }

        return $res;
    }

    /**
     * @param $value
     * @return bool
     */
    final public static function has($value)
    {
        return in_array($value, static::getList()) || static::hasExcluded($value);
    }

    final public static function hasNoExcluded($value)
    {
        return in_array($value, static::getList());
    }

    final public static function hasExcluded($value)
    {
        return in_array($value, static::getExcludedList());
    }

}