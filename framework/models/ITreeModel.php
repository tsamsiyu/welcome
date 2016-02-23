<?php namespace welcome\models;

interface ITreeModel extends IModel
{
    public function addBranch($name, $class, $asSet, array $properties = [], array $options = null);

    public function removeBranch($name, array $options = null);

    public function getBranch($name, array $options = null);

    public function setAsBranch($initiator, $name, array $properties = [], array $options = null);

    public function getTreeList($exclude);

}