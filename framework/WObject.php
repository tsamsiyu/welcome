<?php namespace welcome;

use welcome\interfaces\IAccessible;
use welcome\traits\AccessibleTrait;
use welcome\traits\InitTraits;
use welcome\traits\ReflectionTrait;

/**
 * Class WObject
 * @package welcome
 */
class WObject implements IAccessible
{
    use ReflectionTrait;
    use InitTraits;
    use AccessibleTrait;

    private $_components;


    public function __construct()
    {
        $this->initTraits();
    }

    public function __get($name)
    {
        return $this->getIt($name);
    }

    public function __set($name, $value)
    {
        $this->setIt($name, $value);
    }

    public function __call($name, array $arguments)
    {
        return $this->callIt($name, $arguments);
    }

    public static function __callStatic($name, array $arguments)
    {
        return static::callItStatically($name, $arguments);
    }

    public function setConfig(array $config)
    {
        foreach ($config as $component) {
            $this->registerComponent($component);
        }
    }

    public function registerComponent($component)
    {
        // TODO: implement this method in feature
    }
}