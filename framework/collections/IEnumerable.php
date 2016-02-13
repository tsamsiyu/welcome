<?php namespace welcome\collections;

interface IEnumerable
{
    public static function getList();

    public static function has($value);
}