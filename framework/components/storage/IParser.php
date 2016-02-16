<?php namespace welcome\components\storage;

interface IParser
{
    /**
     * @param $string
     * @param array|null $options
     * @return mixed
     */
    public static function decode($string, array $options = null);

    /**
     * @param array $data
     * @param array|null $options
     * @return mixed
     */
    public static function encode(array $data, array $options = null);
}