<?php namespace welcome\di\aspects;

use welcome\di\beans\IBeanable;
use welcome\interfaces\IAccessible;

interface IProxiable extends IAccessible
{
    public function delegateGetter($name, IBeanable $bean);

    public function delegateSetter($name, $value, IBeanable $bean);

    public function delegateCall($name, array $arguments, IBeanable $bean);

    public static function delegateStaticCall($name, array $arguments, $className);
}