<?php namespace welcome\collections;

use Traversable;
use welcome\collections\enum\TypeEnum;

class SimpleCollection implements \ArrayAccess, \IteratorAggregate, \Countable, \Serializable, \JsonSerializable
{
    private $_container = [];
    private $_containerName = '_container';
    protected $_type = null;

    /**
     * SimpleCollection constructor.
     * @param array $container
     * @param string $type
     */
    public function __construct(array $container = [], $type = null)
    {
        $this->{$this->_containerName} = $container;
        if ($type) {
            if (TypeEnum::has($type)) {
                $this->_type = new TypeEnum($type);
            } else {
                $this->_type = new TypeEnum(TypeEnum::USER_DEFINED, $type);
            }
            $this->checkContainer();
        }
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
        return new \ArrayIterator($this->{$this->_containerName});
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->{$this->_containerName});
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->{$this->_containerName}[$offset];
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if ($this->_type && !$this->_type->isSuited($value)) {
            throw new \InvalidArgumentException("Passed value should have the `$value` type.");
        }

        if (is_null($offset)) {
            $this->{$this->_containerName}[] = $value;
        } else {
            $this->{$this->_containerName}[$offset] = $value;
        }
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->{$this->_containerName}[$offset]);
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize($this->{$this->_containerName});
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        $this->{$this->_containerName} = unserialize($serialized);
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
        return count($this->{$this->_containerName});
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return json_encode($this->{$this->_containerName});
    }

    protected function checkContainer()
    {
        if ($this->_type) {
            foreach ($this->{$this->_containerName} as $value) {
                if (!$this->_type->isSuited($value)) {
                    throw new \InvalidArgumentException("Passed value should have the `$this->_type` type.");
                }
            }
        }
    }

    /**
     * @param string $containerName
     */
    public function setContainerName($containerName)
    {
        if (property_exists($this, $containerName)) {
            $this->_containerName = $containerName;
        } else {
            throw new \InvalidArgumentException("Such property missing: `$containerName`");
        }
    }

    /**
     * @return string
     */
    public function getContainerName()
    {
        return $this->_containerName;
    }

}