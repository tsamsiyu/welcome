<?php namespace welcome\di\aspects;

use welcome\reflections\ReflectionManager;
use welcome\W;

abstract class AbstractClassCurator implements IClassCurator
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
        W::getProxyManager()->beanGet($this->_controlled, $name, $this);
    }

    public function __set($name, $value)
    {
        W::getProxyManager()->beanSet($this->_controlled, $name, $this);
    }

    public function __call($name, array $arguments)
    {
//        W::getProxyManager()->beanCall($this->_controlled, $name, $this);
    }

    public static function __callStatic($name, array $arguments)
    {
//        W::getProxyManager()->beanCallStatic($this->_controlled, $name, $this);
    }
}