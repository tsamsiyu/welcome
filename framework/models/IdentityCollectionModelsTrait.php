<?php namespace welcome\models;

trait IdentityCollectionModelsTrait
{
    public function getAttributes($id, $exclude = null)
    {
        return $this->getMember($id)->getAttributes($exclude);
    }

    public function setAttributes($id, array $attributes = [])
    {
        $this->getMember($id)->setAttributes($attributes);
    }

    /**
     * @param $id
     * @return IModel
     */
    public function getMember($id)
    {
        foreach ($this as $item) {
            /* @var IIdentityModel $item */
            if ($item->getId() === $id) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @param $id
     * @return bool
     */
    public function hasMember($id)
    {
        return $this->getMember($id) instanceof IIdentityModel;
    }

    /**
     * @param $id
     * @return IModel
     */
    public function pullMember($id)
    {
        foreach ($this as $k => $item) {
            /* @var IIdentityModel $item */
            if ($item->getId() === $id) {
                $element = clone $item;
                unset($this[$k]);
                return $element;
            }
        }

        return null;
    }

}