<?php namespace welcome\di;

trait BeanableTrait
{
    public function isImplement($class)
    {
        return $this instanceof $class;
    }
}