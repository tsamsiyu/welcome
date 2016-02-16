<?php namespace welcome\di\aspects;

use welcome\di\BeanableTrait;
use welcome\di\beans\IBeanable;
use welcome\di\ProxiableTrait;
use welcome\WObject;

/**
 * Class BaseBean
 * @package welcome\di\aspects
 */
class BaseBean extends WObject implements IBeanable, IProxiable
{
    use BeanableTrait;
    use ProxiableTrait;

    public function __get($name)
    {
        return $this->delegateGetter($name, $this);
    }

    public function __set($name, $value)
    {
        $this->delegateSetter($name, $value, $this);
    }

    public function __call($name, array $arguments)
    {
        return $this->delegateCall($name, $arguments, $this);
    }

    public static function __callStatic($name, array $arguments)
    {
        return static::delegateStaticCall($name, $arguments, static::class);
    }

}