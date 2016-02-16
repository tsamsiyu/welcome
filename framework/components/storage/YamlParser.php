<?php namespace welcome\components\storage;

class YamlParser implements IParser
{

    /**
     * @param $string
     * @param array|null $options
     * @return mixed
     */
    public static function decode($string, array $options = null)
    {
        return \Spyc::YAMLLoadString($string);
    }

    /**
     * @param array $data
     * @param array|null $options
     * @return mixed
     */
    public static function encode(array $data, array $options = null)
    {
        return \Spyc::YAMLDump($data);
    }
}