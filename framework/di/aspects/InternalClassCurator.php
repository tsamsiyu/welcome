<?php namespace welcome\di\aspects;

use welcome\reflections\ReflectionManager;
use welcome\W;

class InternalClassCurator extends AbstractClassCurator
{

    public function hasPropertyAccess($name, $static = false)
    {
        return true;
    }

    public function hasMethodAccess($name, $static = false)
    {
        return true;
    }
}