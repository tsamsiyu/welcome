<?php namespace welcome\di\aspects;

use welcome\reflections\ReflectionManager;
use welcome\W;

class InternalPropertyCurator
{
    protected $_controlled;
    protected $_reflector;


    public function __construct(IProxiable $component)
    {
        $this->_controlled = $component;
        $this->_reflector = ReflectionManager::getInstance($this->_controlled);
    }

    public function __get($name)
    {
        W::getAspectManager()->beanGet($this->_controlled, $name, $this->_reflector);
    }

    public function __set($name, $value)
    {

    }

    public function __call($name, array $arguments)
    {

    }

    public static function __callStatic($name, array $arguments)
    {

    }

}