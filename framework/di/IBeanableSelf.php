<?php namespace welcome\di;

interface IBeanableSelf extends IBeanable
{
    public function getSingletonBean();

    public function getBean();
}