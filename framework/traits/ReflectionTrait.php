<?php namespace welcome\traits;

/**
 * Class ReflectionTrait
 * @package welcome\traits
 */
trait ReflectionTrait
{
    private static $_reflectionClass;

    /**
     * @return \ReflectionClass
     */
    public static function getReflectionClass()
    {
        if (!self::$_reflectionClass) {
            self::$_reflectionClass = new \ReflectionClass(static::class);
        }

        return self::$_reflectionClass;
    }

    public static function hasStaticProperty($name, $access)
    {
        $reflection = static::getReflectionClass();
        if ($reflection->hasProperty($name)) {
            $method = $reflection->getProperty($name);
            if ($method->isStatic()) {
                if ($access !== null) {
                    return static::hasReflectionAccess($method, $access);
                }
                return true;
            }
        }

        return false;
    }

    public static function hasStaticMethod($name, $access)
    {
        $reflection = static::getReflectionClass();
        if ($reflection->hasMethod($name)) {
            $method = $reflection->getMethod($name);
            if ($method->isStatic()) {
                if ($access !== null) {
                    return static::hasReflectionAccess($method, $access);
                }
                return true;
            }
        }

        return false;
    }

    public static function hasProperty($name, $access = null)
    {
        $reflection = static::getReflectionClass();
        if ($reflection->hasProperty($name)) {
            if ($access !== null) {
                $prop = $reflection->getProperty($name);
                return static::hasReflectionAccess($prop, $access);
            }
            return true;
        }

        return false;
    }

    public static function hasMethod($name, $access = null)
    {
        $reflection = static::getReflectionClass();
        if ($reflection->hasMethod($name)) {
            if ($access !== null) {
                $method = $reflection->getMethod($name);
                return static::hasReflectionAccess($method, $access);
            }
            return true;
        }

        return false;
    }

    /**
     * @param $entity
     * @param $access
     * @return bool
     * @throws \Exception
     */
    public static function hasReflectionAccess($entity, $access)
    {
        if (!($entity instanceof \ReflectionMethod) && !($entity instanceof \ReflectionProperty)) {
            throw new \InvalidArgumentException('This method support only method and property reflections, ' . get_class($entity) . ' passed.');
        }

        /* @var \ReflectionMethod|\ReflectionProperty $scope - full namespace of class */
        $scope = get_class($entity);
        switch ($access) {
            case $scope::IS_PUBLIC:
                return $entity->isPublic();
                break;
            case $scope::IS_PROTECTED:
                return $entity->isProtected();
                break;
            case $scope::IS_PRIVATE:
                return $entity->isPrivate();
        }

        throw new \Exception('This access is unavailable: ' . $access);
    }

}