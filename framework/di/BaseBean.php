<?php namespace welcome\di;

use welcome\WObject;

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
        return static::delegateCallStatic($name, $arguments, static::class);
    }

}