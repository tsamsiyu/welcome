<?php namespace welcome\di;


use welcome\interfaces\IAccessible;

interface IBeanable extends IAccessible
{
    public function getSingletonBean();

    public function getBean();

    public function afterBeanCreate();

    public function afterBeanInit();

}