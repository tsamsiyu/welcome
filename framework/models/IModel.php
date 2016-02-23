<?php namespace welcome\models;

interface IModel
{
    /**
     * @param array $attributes
     * @param array|null $options
     * @return boolean
     */
    public function validate(array $attributes = [], array $options = null);

    /**
     * @param null $exclude attributes names to exclude from returned list
     * @return array
     */
    public function getAttributes($exclude = null);

    public function setAttributes(array $list = []);

}