<?php namespace welcome\di\aspects;

interface IClassCurator
{
    const METHOD = 17;
    const PROPERTY = 27;

    public function hasPropertyAccess($name, $static = false);

    public function hasMethodAccess($name, $static = false);
}