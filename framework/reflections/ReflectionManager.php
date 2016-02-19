<?php namespace welcome\reflections;

class ReflectionManager
{
    private static $_instances = [];
    private static $_reflector = CachedReflection::class;

    public static function setReflector(\Reflector $classScope)
    {
        static::$_reflector = $classScope;
    }

    public static function getReflector()
    {
        return static::$_reflector;
    }

    /**
     * @param $class
     * @return CachedReflection
     */
    public static function getInstance($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        if (!static::hasInstance($class)) {
            static::createInstance($class);
        }

        return static::$_instances[$class];
    }

    public static function destroyInstance($class)
    {
        if (isset(static::$_instances[$class])) {
            unset(static::$_instances[$class]);
            return true;
        }
        return false;
    }

    /**
     * @param $class
     * @return bool
     */
    public static function hasInstance($class)
    {
        return isset(static::$_instances[$class]);
    }

    protected static function createInstance($class)
    {
        $reflector = static::$_reflector;
        static::$_instances[$class] = new $reflector($class);
    }

}