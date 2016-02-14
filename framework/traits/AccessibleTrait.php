<?php namespace welcome\traits;

/**
 * @dependency ReflectionTrait
 *
 * @method \ReflectionClass getReflectionClass
 * @method bool hasProperty(string $name, integer $access)
 * @method bool hasMethod(string $name, integer $access)
 *
 * Class PropertyAccessTrait
 * @package welcome\traits
 */
trait AccessibleTrait
{
    public function canGetProperty($name)
    {
        if (static::hasProperty($name, \ReflectionProperty::IS_PUBLIC)) {
            return true;
        }
        if (static::hasMethod('get' . ucfirst($name), \ReflectionMethod::IS_PUBLIC)) {
            return true;
        }
        return false;
    }

    public function canSetProperty($name)
    {
        if (static::hasProperty($name, \ReflectionProperty::IS_PUBLIC)) {
            return true;
        }
        if (static::hasMethod('set' . ucfirst($name), \ReflectionMethod::IS_PUBLIC)) {
            return true;
        }
        return false;
    }

    public function getIt($name)
    {
        if (static::hasProperty($name, \ReflectionProperty::IS_PUBLIC)) {
            return $this->$name;
        }
        if (static::hasMethod('get' . ucfirst($name), \ReflectionMethod::IS_PUBLIC)) {
            return call_user_func([$this, 'get' . ucfirst($name)]);
        }

        throw new \InvalidArgumentException('Undefined property ' . $name);
    }

    public function setIt($name, $value)
    {
        if (static::hasProperty($name, \ReflectionProperty::IS_PUBLIC)) {
            $this->$name = $value;
            return null;
        }
        if (static::hasMethod('set' . ucfirst($name), \ReflectionMethod::IS_PUBLIC)) {
            return call_user_func_array([$this, $name], [$value]);
        }

        throw new \InvalidArgumentException('Undefined property ' . $name);
    }

    public function callIt($name, array $arguments)
    {
        return call_user_func_array([$this, $name], $arguments);
    }

    public static function callItStatically($name, array $arguments)
    {
        return call_user_func_array([static::class, $name], $arguments);
    }

    public function setProperty($name, $value)
    {
        $this->setIt($name, $value);

        return $this;
    }

}