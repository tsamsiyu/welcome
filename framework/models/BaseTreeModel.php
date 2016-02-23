<?php namespace welcome\models;

class BaseTreeModel extends BaseModel implements ITreeModel
{
    use BrancheableTrait;


    public function __get($name)
    {
        if ($this->hasBranch($name)) {
            return $this->getBranch($name);
        }

        return parent::__get($name);
    }

}