<?php namespace welcome\di\aspects;

use welcome\di\beans\IBeanable;

interface IProxiable
{
    public function delegateGetter($name, IBeanable $bean);

    public function delegateSetter($name, $value, IBeanable $bean);

    public function delegateCall($name, array $arguments, IBeanable $bean);

    public static function delegateStaticCall($name, array $arguments, $className);
}