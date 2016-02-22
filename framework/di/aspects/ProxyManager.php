<?php namespace welcome\di\aspects;

use welcome\di\beans\IBeanable;
use welcome\WObject;

class ProxyManager extends WObject
{
    public function beanGet(IProxiable $component, $property, IClassCurator $classCurator)
    {
        if ($classCurator->hasPropertyAccess($property)) {
            return $component->getIt($property);
        }

        $componentClass = get_class($component);
        throw new \Exception("Property `{$property}` was not defined in `{$componentClass}`");
    }

    public function beanSet(IProxiable $bean, $property, $value)
    {
        return $bean->setIt($property, $value);
    }

    public function beanCall(IProxiable $bean, $method, array $arguments, IClassCurator $classCurator)
    {
        return $bean->callIt($method, $arguments);
    }

    public function beanCallStatic($className, $method, array $arguments, IClassCurator $classCurator)
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