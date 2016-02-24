<?php namespace welcome\models;

use welcome\collections\AryFilter;

/**
 * @method getAttributes(array $attributes = [], array $options = null)
 *
 * Class BrancheableTrait
 * @package welcome\models
 */
trait BrancheableTrait
{
    /**
     * @var [][]|ITreeModel[]
     */
    protected $_branches;
    protected $_parent;
    protected $_parentProp;


    public function addBranch($name, $class, $asSet, array $properties = [], array $options = [])
    {
        if (!is_subclass_of($class, ITreeModel::class)) {
            $c = IModel::class;
            throw new \Exception("Model branch must be subclass of `{$c}`");
        }

        $lazy = AryFilter::pull($options, 'lazy', ['failVal' => false]);

        if ($lazy) {
            $this->_branches[$name] = [$class, $asSet, $properties, $options];
        } else {
            $this->createBranch($name, [$class, $asSet, $properties, $options]);
        }
    }

    public function removeBranch($name, array $options = null)
    {
        unset($this->_branches[$name]);
    }

    public function hasBranch($name)
    {
        return isset($this->_branches[$name]);
    }

    /**
     * @param $name
     * @param array|null $options
     * @return ITreeModel
     */
    public function getBranch($name, array $options = null)
    {
        if ($this->hasBranch($name)) {
            if (is_array($this->_branches[$name])) {
                $this->createBranch($name, $this->_branches[$name]);
            }

            return $this->_branches[$name];
        }

        return null;
    }

    public function getBranches()
    {
        return array_keys($this->_branches);
    }

    /**
     * @return string
     */
    public function getParentProp()
    {
        return $this->_parentProp;
    }

    /**
     * @return IModel
     */
    public function getParent()
    {
        return $this->_parent;
    }

    protected function createBranch($name, array $branchOptions)
    {
        list($class, $asSet, $properties, $options) = $branchOptions;
        /* @var ITreeModel $branch */
        if ($asSet) {
            $branch = new ModelsCollection($class);
        } else {
            $branch = new $class;
        }
        $branch->setAsBranch($this, $name, $properties, $options);

        $this->_branches[$name] = $branch;
    }


    public function getTreeList($exclude = null)
    {
        $res = $this->getAttributes();
        foreach ($this->getBranches() as $branchName) {
            $res[$branchName] = $this->getBranch($branchName)->getTreeList($exclude);
        }

        return $res;
    }

    public function setAsBranch($initiator, $prop, array $properties = [], array $options = null)
    {
        $this->_parent = $initiator;
        $this->_parentProp = $prop;
    }
}