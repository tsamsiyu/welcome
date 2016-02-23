<?php namespace welcome\models;

use welcome\collections\Tree;

class ModelsCollection extends Tree implements ITreeModel
{
    use BrancheableTrait;

    public function __construct($class)
    {
        if (!is_subclass_of($class, ITreeModel::class)) {
            throw new \InvalidArgumentException("Collection item must be implement `ITreeModel`.");
        }

        parent::__construct([], $class);
    }

    public function validate(array $attributeNames = [], array $options = null)
    {
        $ok = true;
        foreach ($this as $model) {
            /* @var IModel $model */
            $ok = $model->validate($attributeNames) && $ok;
        }

        return $ok;
    }

    public function addMember(array $attributes)
    {
        $scope = $this->_type;
        /* @var ITreeModel $model */
        $model = new $scope;
        $model->setAttributes($attributes);
        $this[] = $model;
    }

    /**
     * @param null $exclude attributes names to exclude from returned list
     * @return array
     */
    public function getAttributes($exclude = null)
    {
        // TODO: Implement getAttributes() method.
    }

    public function setAttributes(array $list = [])
    {
        // TODO: Implement setAttributes() method.
    }
}