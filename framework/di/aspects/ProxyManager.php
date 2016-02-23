<?php namespace welcome\di\aspects;

use welcome\di\beans\IBeanable;
use welcome\WObject;

class ProxyManager extends WObject
{
    public function handle(JoinPoint $joinPoint)
    {
        return $joinPoint->initiate();
    }
}