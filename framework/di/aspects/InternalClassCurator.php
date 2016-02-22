<?php namespace welcome\di\aspects;

use welcome\reflections\ReflectionManager;
use welcome\W;

class InternalClassCurator extends AbstractClassCurator
{
    public function hasAccess($property, $entityType)
    {
        return true;
    }
}