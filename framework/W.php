<?php namespace welcome;

use welcome\di\Conveyor;

class W extends WObject
{
    private static $_conveyor;


    /**
     * @return Conveyor
     */
    public static function getConveyor()
    {
        if (!isset(static::$_conveyor)) {
            static::$_conveyor = new Conveyor();
        }

        return static::$_conveyor;
    }
}