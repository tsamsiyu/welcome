<?php namespace welcome\components\i18n;

interface ISource
{
    public function getSegment($segment, $alias = null);

    public function setAlias($segment, $alias = null);

    public function useAlias($alias);

    public function getAlias($name = '', $asPath = false);
}