<?php namespace welcome\components\i18n;

use welcome\collections\AryHelp;
use welcome\components\storage\Fs;
use welcome\components\storage\Io;

class FileSource implements ISource
{
    protected $_set = [];
    protected $_path;
    protected $_usableAlias = self::DEFAULT_ALIAS;
    protected $_aliases = [self::DEFAULT_ALIAS => []];

    public $segmentSplitter = '.';

    const DEFAULT_ALIAS = '@default';
    const FILE_GENERAL = '_';


    public function __construct($path)
    {
        if (!is_dir($path)) {
            throw new \InvalidArgumentException('Path in filesystem is missing.');
        }
        $this->_path = $path;
    }

    public function getPath()
    {
        return $this->_path;
    }

    public function getUsableAlias()
    {
        return $this->_usableAlias;
    }

    public function setAlias($segment, $alias = null)
    {
        $alias = $alias ?: $this->_usableAlias;
        $pathSegment = str_replace($this->segmentSplitter, DIRECTORY_SEPARATOR, $segment);

        if (Fs::specify($this->_path, $pathSegment)) {
            $this->_aliases[$alias] = $pathSegment;
        }

        return $this;
    }

    public function useAlias($name)
    {
        if (isset($this->_aliases[$name])) {
            $this->_usableAlias = $name;
        } else {
            $this->_usableAlias = null;
        }

        return $this;
    }

    public function getAlias($name = '', $asPath = false)
    {
        if (!$name && $this->_usableAlias) {
            $alias = $this->_aliases[$this->_usableAlias];
        } elseif (isset($this->_aliases[$name])) {
            $alias = $this->_aliases[$name];
        } else {
            return false;
        }

        if ($asPath) {
            return Fs::join($alias);
        }
        return $alias;
    }

    public function getSegment($segment = null, $alias = null)
    {
        $alias = $this->getAlias($alias, true);
        if ($alias === false) {
            return '';
        }

        if (is_string($segment)) {
            $segment = explode($this->segmentSplitter, $segment);
        }

        $path = Fs::join($this->_path, $alias);

        if ($file = Fs::specify($path)) {
            if (isset($this->_set[$alias])) {
                if ($segment) {
                    if ($v = AryHelp::getBySegment($this->_set[$alias], $segment, $this->segmentSplitter)) {
                        return $v;
                    }
                } else {
                    return $this->_set[$alias];
                }
            } else {
                if ($val = $this->loadSegment($alias, $file, $segment)) {
                    return $val;
                }
            }
        }

        if ($val = $this->findGeneralSegment($alias, $segment)) {
            return $val;
        } elseif ($val = $this->loadGeneralSegment($alias, $segment)) {
            return $val;
        }

        return '';
    }

    public function loadSegment($alias, $file, array $segment = null)
    {
        $data = Io::read($file);
        $this->addLabels($alias, $data);
        if ($segment) {
            return AryHelp::getBySegment($this->_set[$alias], $segment, $this->segmentSplitter);
        } else {
            return $data;
        }
    }

    public function addLabels($externalSegment, $data)
    {
        if (is_array($externalSegment)) {
            $externalSegment = implode($this->segmentSplitter, $externalSegment);
        }

        if (isset($this->_set[$externalSegment]) && is_array($this->_set[$externalSegment])) {
            $this->_set[$externalSegment] = array_merge($this->_set[$externalSegment], $data);
        } else {
            $this->_set[$externalSegment] = $data;
        }
    }

    public function findGeneralSegment($alias, array $segment = null)
    {
        if ($segment) {
            do {
                $alias = Fs::back($alias);
                $label = Fs::join($alias, self::FILE_GENERAL);
                if (isset($this->_set[$label])) {
                    if ($val = AryHelp::getBySegment($this->_set[$alias], $segment, $this->segmentSplitter)) {
                        return $val;
                    }
                }
            } while($alias);
        }

        return null;
    }

    public function loadGeneralSegment($alias, array $internalSegment = null)
    {
        if ($internalSegment) {
            do {
                $alias = Fs::back($alias);
                $path = Fs::join($this->_path, $alias, self::FILE_GENERAL);
                if ($file = Fs::specify($path)) {
                    var_dump($file);
                    die;
                    $data = Io::read($file);
                    $generalAlias = Fs::join($alias, self::FILE_GENERAL);
                    $this->addLabels($generalAlias, $data);
                    if ($val = AryHelp::getBySegment($this->_set[$generalAlias], $internalSegment, $this->segmentSplitter)) {
                        return $val;
                    }
                }
            } while($alias);
        }

        return null;
    }

}