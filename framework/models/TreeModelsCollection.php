<?php namespace welcome\models;

class TreeModelsCollection extends ModelsCollection implements ITreeModelsCollection
{
    use BrancheableTrait;

    public function getTreeList($exclude = null)
    {
        $res = [];
        foreach ($this as $key => $item) {
            /* @var ITreeModel $item  */
            $res[$key] = $item->getTreeList();
        }

        return $res;
    }
}