<?php namespace welcome;

use welcome\di\Aspector;
use welcome\di\Conveyor;

class W
{
    private static $_conveyor;
    private static $_aspector;


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

    /**
     * @return Aspector
     */
    public static function getAspector()
    {
        if (!isset(static::$_aspector)) {
            static::$_aspector = new Aspector();
        }

        return static::$_aspector;
    }

}