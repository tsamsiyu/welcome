<?php namespace welcome\models;

interface IModelsCollection
{
    public function validate(array $attributeNames = [], array $options = null);

    public function addMember(array $attributes);
}