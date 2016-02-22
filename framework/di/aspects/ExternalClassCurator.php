<?php namespace welcome\di\aspects;

class ExternalClassCurator extends AbstractClassCurator
{

    public function hasPropertyAccess($name, $static = false)
    {
        if ($this->_reflector->hasProperty($name)) {
            $property = $this->_reflector->getProperty($name);
            if ($property->isPrivate() || $property->isProtected()) {
                return false;
            }
        }

        return true;
    }

    public function hasMethodAccess($name, $static = false)
    {
        if ($this->_reflector->hasMethod($name)) {
            $method = $this->_reflector->getMethod($name);
            if ($method->isPrivate() || $method->isProtected()) {
                return false;
            }
        }

        return true;
    }
}