<?php namespace welcome\collections\enum;

use welcome\collections\Enum;

class FilterEnum extends Enum
{
    const DIR = 'is_dir';
    const FILE = 'is_file';
    const TYPE = TypeEnum::class . '::check';


    /**
     * @param $value
     * @param $filter
     * @return bool
     */
    public static function filter($value, $filter)
    {
        if (static::has($filter)) {
            $value = (array)$value;
            return (boolean)call_user_func_array($filter, $value);
        }
        throw new \InvalidArgumentException('Passed argument is not available filter.');
    }
}