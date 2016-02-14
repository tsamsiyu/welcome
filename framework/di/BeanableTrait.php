<?php namespace welcome\di;

use welcome\W;

trait BeanableTrait
{
    public function afterBeanCreate(){}

    public function afterBeanInit(){}

    public function getSingletonBean()
    {
        return W::getConveyor()->getSingleton(static::class);
    }

    public function getBean()
    {
        return W::getConveyor()->get(static::class);
    }

    public function initBeanableTrait()
    {
        W::getConveyor()->set([
            '#scope' => static::class
        ]);
    }

}