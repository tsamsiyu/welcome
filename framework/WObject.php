<?php namespace welcome;

use welcome\traits\InitTraits;

/**
 * Class WObject
 * @package welcome
 */
class WObject
{
    use InitTraits;

    public function __construct()
    {
        $this->initTraits();
    }

    public function hasProperty($name)
    {
        return property_exists($this, $name);
    }

    public function hasMethod($name)
    {
        return method_exists($this, $name);
    }
}