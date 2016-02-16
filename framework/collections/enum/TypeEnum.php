<?php namespace welcome\collections\enum;

use welcome\collections\Enum;

class TypeEnum extends Enum
{
    const INT = 'integer';
    const FLOAT = 'float';
    const STRING = 'string';
    const ARY = 'array';
    const OBJ = 'object';
    const BOOL = 'boolean';
    const CALLBACK = 'callable';

    const SCALAR = 'scalar';
    const COMPLEX = 'complex';


    public static function groups()
    {
        return [
            'common' => ['SCALAR', 'COMPLEX'],
            'specific' => ['INT', 'FLOAT', 'STRING', 'ARY', 'OBJ', 'BOOL', 'CALLBACK']
        ];
    }

    public static function check($value, $type)
    {
        if (static::has($type)) {
            switch($type) {
                case self::INT:
                    return is_integer($value); break;
                case self::FLOAT:
                    return is_float($value); break;
                case self::STRING:
                    return is_string($value); break;
                case self::ARY:
                    return is_array($value); break;
                case self::OBJ:
                    return is_object($value); break;
                case self::BOOL:
                    return is_bool($value); break;
                case self::CALLBACK:
                    return is_callable($value); break;
            }
        }
        throw new \InvalidArgumentException('Passed argument is not available type.');
    }

}