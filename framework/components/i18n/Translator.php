<?php namespace welcome\components\i18n;

class Translator implements ITranslator
{
    protected $_dataSource;
    protected $_changeableSource;

    public function t($segment, $alias = null)
    {
        /*if ($t = $this->_changeableSource->getSegment($segment, $alias)) {
            return $t;
        } elseif ($t = $this->_dataSource->getSegment($segment, $alias)) {
            return $t;
        }*/
        var_dump($this->_changeableSource->getSegment($segment, $alias));

        return '';
    }

    public function __construct(IChangeableSource $changeableSource, ISource $dataSource)
    {
        $this->_changeableSource = $changeableSource;
        $this->_dataSource = $dataSource;
    }

    public function setAlias($segment, $alias = null)
    {
        $this->_dataSource->setAlias($segment, $alias);
        $this->_changeableSource->setAlias($segment, $alias);
        return $this;
    }

    public function useAlias($alias)
    {
        $this->_dataSource->useAlias($alias);
        $this->_changeableSource->useAlias($alias);
        return $this;
    }
}