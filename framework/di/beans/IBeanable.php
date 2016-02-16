<?php namespace welcome\di\beans;


use welcome\interfaces\IAccessible;

interface IBeanable extends IAccessible
{
    public function getSingletonBean();

    public function getBean();

    public function afterBeanCreate();

    public function afterBeanInit();

    public function beforeBeanDestroy();

}