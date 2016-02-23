<?php namespace welcome\di\aspects;

use welcome\interfaces\IAccessible;
use welcome\reflections\ReflectionManager;
use welcome\W;

class ClassCurator
{
    const METHOD = 17;
    const PROPERTY = 27;

    protected $_controlled;
    protected $_reflector;
    protected $_class;
    protected $_context = false;

    public static function in($class, $context = false)
    {
        // TODO: add cache for instances only for class.
        return new static($class, $context);
    }

    public function __construct($option, $context = false)
    {
        if (is_string($option)) {
            if (!is_subclass_of($option, IAccessible::class)) {
                $c = IAccessible::class;
                throw new \InvalidArgumentException("Class must be subclass of `$c`");
            }
            $this->_class = $option;
        } elseif ($option instanceof IAccessible) {
            $this->_controlled = $option;
            $this->_class = get_class($option);
            $this->_reflector = ReflectionManager::getInstance($this->_controlled);
        } else {
            $c = IAccessible::class;
            throw new \InvalidArgumentException("Passed argument must be class that implemented `$c` or `$c` instance.");
        }

        $this->_reflector = ReflectionManager::getInstance($option);
        $this->_context = (boolean)$context;
    }

    public function __get($name)
    {
        $joinPoint = new JoinPoint($this->_reflector, JoinPoint::GET, $name, $this->_class, $this->_context, $this->_controlled);
        return W::getProxyManager()->handle($joinPoint);
    }

    public function __set($name, $value)
    {
        $joinPoint = new JoinPoint($this->_reflector, JoinPoint::SET, $name, $this->_class, $this->_context, $this->_controlled);
        W::getProxyManager()->handle($joinPoint);
    }

    public function __call($name, array $arguments)
    {
        $joinPoint = new JoinPoint($this->_reflector, JoinPoint::CALL, $name, $this->_class, $this->_context, $this->_controlled);
        return W::getProxyManager()->handle($joinPoint);
    }

}