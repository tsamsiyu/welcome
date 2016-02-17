<?php namespace welcome\collections;


use Traversable;
use welcome\interfaces\IEnumerable;
use welcome\reflections\ReflectionManager;

class Enum implements IEnumerable, \IteratorAggregate, \Countable
{
    protected $_value;


    public function __construct($value)
    {
        if (static::has($value)) {
            $this->_value = $value;
            return;
        }
        throw new \Exception("Enum has no value `$value`");
    }

    public function getValue()
    {
        return $this->_value;
    }

    public function __toString()
    {
        return (string)$this->_value;
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

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->getList());
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->getList());
    }
}