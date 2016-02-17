<?php namespace welcome\di;

use welcome\W;

trait BeanableTrait
{
    public function afterBeanCreate() {}

    public function afterBeanInit() {}

    public function beforeBeanDestroy() {}

    public function getSingletonBean()
    {
        return W::getBeansManager()->getSingleton(static::class);
    }

    public function getBean()
    {
        return W::getBeansManager()->get(static::class);
    }

    public function initBeanableTrait()
    {
        W::getBeansManager()->set([
            '#scope' => static::class
        ]);
    }

}