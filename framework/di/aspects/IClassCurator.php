<?php namespace welcome\di\aspects;

interface IClassCurator
{
    const METHOD = 17;
    const PROPERTY = 27;

    public function hasAccess($property, $entityType);
}