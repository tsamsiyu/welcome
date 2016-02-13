<?php namespace welcome\collections;

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


    public static function check($type, $value, $excluded = false)
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
                case self::SCALAR:
                    if (!$excluded) {
                        return is_scalar($value); break;
                    } else {
                        continue;
                    }
                case self::COMPLEX:
                    if (!$excluded) {
                        return !is_scalar($value); break;
                    }
            }
        }
        throw new \InvalidArgumentException('Passed argument is not available type.');
    }

    public static function getExcluded()
    {
        return ['SCALAR', 'COMPLEX'];
    }

}