<?php namespace welcome\di;

use welcome\di\beans\IBeanable;
use welcome\W;

trait ProxiableTrait
{
    public function delegateGetter($name, IBeanable $bean)
    {
        return W::getAspector()->beanGet($bean, $name);
    }

    public function delegateSetter($name, $value, IBeanable $bean)
    {
        return W::getAspector()->beanSet($bean, $name, $value);
    }

    public function delegateCall($name, array $arguments, IBeanable $bean)
    {
        return W::getAspector()->beanCall($bean, $name, $arguments);
    }

    public static function delegateStaticCall($name, array $arguments, $className)
    {
        return W::getAspector()->beanCallStatic($className, $name, $arguments);
    }
}