<?php namespace welcome\di;

interface IProxiable
{
    public function delegateGetter($name, IBeanable $bean);

    public function delegateSetter($name, $value, IBeanable $bean);

    public function delegateCall($name, array $arguments, IBeanable $bean);

    public static function delegateCallStatic($name, array $arguments, $className);
}