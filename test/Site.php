<?php

require 'traitB.php';

class Site
{
    use traitB;

    public $p1 = 10;
    protected $p2 = 20;
    private $p3 = 30;
    public static $p11 = 11;
    protected static $p22 = 22;
    private static $p33 = 33;

    public function arara()
    {
        static::testStatic();
    }

    private static function testStatic()
    {
        echo "test static\n";
    }

    public static function __callStatic($a, $b)
    {
        echo "yo";
    }

    public function __get($name)
    {
        var_dump("oi oi oi");
    }

    public function propExists()
    {
        var_dump(property_exists($this, 'p3'));
    }


}