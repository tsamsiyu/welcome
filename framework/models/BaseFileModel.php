<?php namespace welcome\models;

use welcome\components\storage\Fs;
use welcome\components\storage\Io;

class BaseFileModel extends BaseTreeModel
{
    protected $_filePath;
    protected $_storePath;
    protected $_attributes;

    public function __construct($filePath, $storePath = null)
    {
        if (!is_file($filePath)) {
            throw new \InvalidArgumentException("Passed argument must be a file.");
        }

        if ($storePath) {
            if ($storePath === true) {
                $storePath = $filePath;
            } elseif (is_dir($storePath)) {
                $filename = basename($this->_filePath);
                $storePath = Fs::join($storePath, $filename);
            } else {
                throw new \InvalidArgumentException("Passed argument must be a file.");
            }
        }

        $this->_filePath = $filePath;
        $this->_storePath = $storePath;
        $this->read();
    }

    public function nestedClasses()
    {
        return [];
    }

    public function getNestedClass($key)
    {
        $classes = $this->nestedClasses();
        $parentChain = $this->getParentChain($key);
        if (isset($classes[$parentChain])) {
            return $classes[$parentChain];
        }

        return static::class;
    }

    public function getFilePath()
    {
        return $this->_filePath;
    }

    public function getParentChain($key)
    {
        if ($res = $this->getParentProp()) {
            /* @var BaseFileModel $parent */
            $parent = $this->getParent();
            while ($prop = $parent->getParentProp()) {
                $res = "$res.$prop";
                $parent = $parent->getParent();
            }
        } else {
            $res = '';
        }

        return "$res.$key";
    }

    public function setAsBranch(BaseFileModel $initiator, $prop, array $properties = [], array $options = null)
    {
        $this->_parent = $initiator;
        $this->_parentProp = $prop;
        $this->_filePath = $initiator->getFilePath();
        $this->setTree($properties);
    }

    public function setTree(array $data)
    {
        foreach ($data as $key => $val) {
            if (is_integer($key)) {
                throw new \Exception("Name property must be a string.");
            }

            if (is_array($val)) {
                $asSet = true;
                foreach ($val as $nestedKey => $nestedVal) {
                    if (!is_integer($nestedKey) || !is_array($nestedVal)) {
                        $asSet = false;
                        break;
                    }
                }

                $this->addBranch($key, $this->getNestedClass($key), $asSet, $val);
            }

            $this->setAttributes([$key => $val]);
        }
    }

    public function read()
    {
        $data = Io::read($this->_filePath);
        $this->setTree($data);
    }

    public function write($path = null)
    {
        if ($path) {
            if (is_dir($path)) {
                $filename = basename($this->_filePath);
                $path = Fs::join($path, $filename);
            } else {
                throw new \InvalidArgumentException("Passed argument must be a file.");
            }
        } elseif (!$this->_storePath) {
            throw new \InvalidArgumentException('Path must be set specified');
        } else {
            $path = $this->_storePath;
        }

        return Io::write($this->getTreeList(), $path);
    }

}