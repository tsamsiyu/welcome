<?php namespace welcome\interfaces;

interface IEnumerable
{
    public static function getList();

    public static function has($value);
}