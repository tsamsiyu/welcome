<?php namespace welcome\collections;


use welcome\collections\enum\TypeEnum;

class AryHelper
{
    public static function pull(array &$data, $key, $failValue = null)
    {
        if (isset($data[$key])) {
            $v = $data[$key];
            unset($data[$key]);
            return $v;
        }
        return $failValue;
    }

    public static function required(array &$data, $key, $type = null, $pull = false)
    {
        if (isset($data[$key])) {
            $v = $data[$key];
            if ($type) {
                if (!TypeEnum::check($type, $v)) {
                    throw new \InvalidArgumentException("Key `$key` have unavailable type.");
                }
            }
            unset($data[$key]);
            return $v;
        }
        throw new \InvalidArgumentException("Key `$key` must be set");
    }

}