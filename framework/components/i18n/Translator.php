<?php namespace welcome\components\i18n;

class Translator implements ITranslator
{
    protected $_dataSource;
    protected $_changeableSource;
    protected $_defaultSource;

    public function t($segment, $alias = null)
    {
//        if ($t = $this->_changeableSource->getSegment($segment, $alias)) {
//            return $t;
//        } elseif ($t = $this->_dataSource->getSegment($segment, $alias)) {
//            return $t;
//        } elseif ($this->_defaultSource) {
//            if ($t = $this->_defaultSource->getSegment($segment, $alias)) {
//                return $t;
//            }
//        }
        return $this->_dataSource->getSegment($segment, $alias);

        return '';
    }

    public function __construct(IChangeableSource $changeableSource, ISource $dataSource, ISource $defaultSource = null)
    {
        $this->_changeableSource = $changeableSource;
        $this->_dataSource = $dataSource;
        $this->_defaultSource = $defaultSource;
    }

    public function setAlias($segment, $alias = null)
    {
        $this->_dataSource->setAlias($segment, $alias);
//        $this->_changeableSource->setAlias($segment, $alias);
        if ($this->_defaultSource) {
            $this->_defaultSource->setAlias($segment, $alias);
        }
        return $this;
    }

    public function useAlias($alias)
    {
        $this->_dataSource->useAlias($alias);
//        $this->_changeableSource->useAlias($alias);
        if ($this->_defaultSource) {
            $this->_defaultSource->useAlias($alias);
        }
        return $this;
    }
}