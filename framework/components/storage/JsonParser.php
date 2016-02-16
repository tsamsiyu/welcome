<?php namespace welcome\components\storage;

class JsonParser implements IParser
{

    /**
     * @param $string
     * @param array|null $options
     * @return mixed
     */
    public static function decode($string, array $options = null)
    {
        return json_decode($string, true);
    }

    /**
     * @param array $data
     * @param array|null $options
     * @return mixed
     */
    public static function encode(array $data, array $options = null)
    {
        return json_encode($data);
    }
}