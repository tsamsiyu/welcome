<?php namespace welcome\di;

use welcome\WObject;

class Aspector extends WObject
{
    public function beanGet(IBeanable $bean, $property)
    {
        return $bean->getIt($property);
    }

    public function beanSet(IBeanable $bean, $property, $value)
    {
        return $bean->setIt($property, $value);
    }

    public function beanCall(IBeanable $bean, $method, array $arguments)
    {
        return $bean->callIt($method, $arguments);
    }

    public function beanCallStatic($className, $method, array $arguments)
    {
        if (!is_subclass_of($className, IBeanable::class)) {
            throw new \Exception("$className must be implement `IBeanable` interface to use aspects functionality.");
        }
        /* @var IBeanable $className - namespace of class */
        return $className::callItStatically($method, $arguments);
    }

    public function registerVarListener(IProxiable $bean, $propertyName, $onlyFirst = false)
    {

    }

    public function registerMethodListener(IProxiable $bean, $methodName, $onlyFirst = false)
    {

    }

    public function registerBefore()
    {

    }

    public function registerAfter()
    {

    }

    public function registerAround()
    {

    }

}