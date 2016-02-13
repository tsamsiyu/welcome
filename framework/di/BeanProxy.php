<?php namespace welcome\di;

use welcome\Proxy;

class BeanProxy extends Proxy
{
    public function __construct(IBeanable $bean)
    {
        parent::__construct($bean);
    }
}