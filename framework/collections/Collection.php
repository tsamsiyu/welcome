<?php namespace welcome\collections;

class Collection extends SimpleCollection
{
    public static function mk(array $container = [], $type = null)
    {
        return new static($container, $type);
    }
}