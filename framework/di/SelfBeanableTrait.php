<?php namespace welcome\di;

use welcome\W;

trait SelfBeanableTrait
{
    use BeanableTrait;

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
        $config = [
            '#scope' => static::class
        ];
        if (property_exists($this, 'afterBeanCreate')) {
            $config['#afterCreate'] = 'afterBeanCreate';
        }
        if (property_exists($this, 'afterBeanInit')) {
            $config['#afterCreate'] = 'afterBeanInit';
        }
        W::getConveyor()->set($config);
    }

}