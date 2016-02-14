<?php namespace welcome\traits;

/**
 * @dependency ReflectionTrait
 *
 * @method \ReflectionClass getReflectionClass
 *
 * Class AccessibleTrait
 * @package welcome\traits
 */
trait SimpleAccessibleTrait
{
    private static $_passiveAccessible = true;


    public function getIt($name)
    {
        if (static::$_passiveAccessible) {
            if ($parent = static::getReflectionClass()->getParentClass()) {
                if ($parent->hasMethod('getIt') && !$parent->getMethod('getIt')->isStatic()) {
                    return parent::getIt($name);
                }
            }
        }

        return $this->$name;
    }

    public function setIt($name, $value)
    {
        if (static::$_passiveAccessible) {
            if ($parent = static::getReflectionClass()->getParentClass()) {
                if ($parent->hasMethod('setIt') && !$parent->getMethod('setIt')->isStatic()) {
                    return parent::setIt($name, $value);
                }
            }
        }

        $this->$name = $value;
        return null;
    }

    public function callIt($name, array $arguments = [])
    {
        if (!static::$_passiveAccessible) {
            if ($parent = static::getReflectionClass()->getParentClass()) {
                if ($parent->hasMethod('callIt') && !$parent->getMethod('callIt')->isStatic()) {
                    return parent::callIt($name, $arguments);
                }
            }
        }

        return call_user_func_array([$this, $name], $arguments);
    }

    public static function callItStatically($name, array $arguments = [])
    {
        if (!static::$_passiveAccessible) {
            if ($parent = static::getReflectionClass()->getParentClass()) {
                if ($parent->hasMethod('callItStatically') && $parent->getMethod('callItStatically')->isStatic()) {
                    return parent::callItStatically($name, $arguments);
                }
            }
        }

        return call_user_func_array([static::class, $name], $arguments);
    }

}