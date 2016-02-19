<?php namespace welcome\collections;

use welcome\collections\enum\TypeEnum;

class Tree extends Collection
{
    const FOR_OBJECTS = 1;
    const FOR_ARRAYS = 2;

    public function __construct(array $container, $type = null)
    {
        if ($type && ($type === TypeEnum::ARY || $type === TypeEnum::OBJ || class_exists($type))) {
            parent::__construct($container, $type);
            return;
        }
        parent::__construct($container, TypeEnum::COMPLEX);
    }

    public function pluck($key, $for = null)
    {
        $res = [];
        foreach ($this as $value) {
            if (is_object($value) && $for !== self::FOR_ARRAYS) {
                if (property_exists($value, $key)) {
                    $res[] = $value->$key;
                }
            } elseif (is_array($value) && $for !== self::FOR_OBJECTS) {
                if (array_key_exists($key, $value)) {
                    $res[] = $value[$key];
                }
            }
        }
        return $res;
    }
}