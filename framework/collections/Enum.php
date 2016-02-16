<?php namespace welcome\collections;


use welcome\interfaces\IEnumerable;
use welcome\reflections\ReflectionManager;

class Enum implements IEnumerable
{
    private $_value;


    public function __construct($value)
    {
        if (static::has($value)) {
            $this->_value = $value;
            return;
        }
        throw new \Exception("Such enum has no value `$value`");
    }

    public function getValue()
    {
        return $this->_value;
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return ReflectionManager::getInstance(static::class)->getConstants();
    }

    /**
     * @param $value
     * @return bool
     */
    final public static function has($value)
    {
        return in_array($value, static::getList());
    }

    /**
     * @return array
     */
    public static function groups()
    {
        return [];
    }

    /**
     * @param string $id
     * @param mixed $failValue
     * @return array|null
     */
    public static function getGroup($id, $failValue = null)
    {
//        $groups = static::groups();
//
//        if (isset($groups[$id])) {
//            return $groups[$id];
//        }
//
//        return $failValue;
    }
}