<?php namespace welcome\models;

interface IIdentityModel
{
    public static function getIdentityAttribute();

    public function getId();

}