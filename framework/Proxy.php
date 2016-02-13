<?php namespace welcome;

/**
 * Class Proxy
 * @package welcome
 */
class Proxy extends WObject
{
    private $_component;

    public function __construct($object)
    {
        parent::__construct();
        $this->_component = $object;
    }

    public function isImplement($className)
    {
        return $this->_component instanceof $className;
    }

    public function __get($name)
    {
        return $this->_component->$name;
    }

    public function __set($name, $value)
    {
        $this->_component->$name = $value;
    }

    public function __call($name, array $arguments)
    {
        if ($this->hasMethod($name)) {
            return call_user_func_array([$this, $name], $arguments);
        }
        return call_user_func_array([$this->_component, $name], $arguments);
    }

}