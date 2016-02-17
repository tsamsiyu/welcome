<?php namespace welcome\collections\enum;

use welcome\collections\Enum;

class TypeEnum extends Enum
{
    protected $_userDefinedType;

    const INT = 'integer';
    const FLOAT = 'float';
    const STRING = 'string';
    const ARY = 'array';
    const OBJ = 'object';
    const BOOL = 'boolean';
    const CALLBACK = 'callable';
    const NULL = 'null';

    const SCALAR = 'scalar';
    const COMPLEX = 'complex';

    const USER_DEFINED = 'user-defined';


    public function __construct($value, $userDefinedType = null)
    {
        if ($value === self::USER_DEFINED) {
            if (class_exists($userDefinedType)) {
                $this->_userDefinedType = $userDefinedType;
                $this->_value = $value;
            } else {
                throw new \InvalidArgumentException('Second argument must be set if type equals to USER_DEFINED.');
            }
        } else {
            parent::__construct($value);
        }
    }

    public function isSuited($value)
    {
        if ($this->_value === self::USER_DEFINED) {
            return $value instanceof $this->_userDefinedType;
        }
        return static::check($value, $this->_value);
    }

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
                case self::NULL:
                    return is_null($value); break;
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
                    return is_scalar($value); break;
                case self::COMPLEX:
                    return !is_scalar($value); break;
            }
        }
        throw new \InvalidArgumentException('Passed argument is not available type.');
    }

}