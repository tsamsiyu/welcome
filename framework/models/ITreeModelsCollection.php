<?php namespace welcome\models;

interface ITreeModelsCollection extends IModelsCollection
{
    public function addBranch($name, $class, $asSet, array $properties = [], array $options = null);

    public function removeBranch($name, array $options = null);

    public function getBranch($name, array $options = null);

    public function setAsBranch($initiator, $name, array $properties = [], array $options = null);

    /**
     * @param $exclude
     * @return array
     */
    public function getTreeList($exclude = null);
}