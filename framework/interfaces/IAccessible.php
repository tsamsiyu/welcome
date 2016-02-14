<?php namespace welcome\interfaces;


interface IAccessible
{
    public function getIt($name);

    public function setIt($name, $value);

    public function callIt($name, array $arguments);

    public static function callItStatically($name, array $arguments);
}