<?php namespace welcome\reflections;

class CachedReflection extends \ReflectionClass
{
    protected $_cachedMethods = [];
    protected $_cachedProperties = [];
    protected $_cachedConstants = [];
    protected $_parent;

    public function getMethod($name)
    {
        if (!isset($this->_cachedMethods[$name])) {
            $this->_cachedMethods[$name] = parent::getMethod($name);
        }
        return $this->_cachedMethods[$name];
    }

    public function getParentClass()
    {
        if (!isset($this->_parent)) {
            $parentReflector = parent::getParentClass();
            $class = $parentReflector->getNamespaceName();
            $this->_parent = new static($class);
            unset($parentReflector);
        }

        return $this->_parent;
    }

    public function getProperty($name)
    {
        if (!isset($this->_cachedProperties[$name])) {
            $this->_cachedProperties[$name] = parent::getProperty($name);
        }
        return $this->_cachedProperties[$name];
    }

    public function getConstant($name)
    {
        if (!isset($this->_cachedConstants[$name])) {
            $this->_cachedConstants[$name] = parent::getConstant($name);
        }
        return $this->_cachedConstants[$name];
    }

    public function hasStaticProperty($name, $access)
    {
        if (parent::hasProperty($name)) {
            $method = $this->getProperty($name);
            if ($method->isStatic()) {
                if ($access !== null) {
                    return $this->hasReflectionAccess($method, $access);
                }
                return true;
            }
        }

        return false;
    }

    public function hasStaticMethod($name, $access)
    {
        if (parent::hasMethod($name)) {
            $method = $this->getMethod($name);
            if ($method->isStatic()) {
                if ($access !== null) {
                    return static::hasReflectionAccess($method, $access);
                }
                return true;
            }
        }

        return false;
    }

    public function hasProperty($name, $access = null)
    {
        if (parent::hasProperty($name)) {
            if ($access !== null) {
                $prop = $this->getProperty($name);
                return static::hasReflectionAccess($prop, $access);
            }
            return true;
        }

        return false;
    }

    public function hasMethod($name, $access = null)
    {
        if (parent::hasMethod($name)) {
            if ($access !== null) {
                $method = $this->getMethod($name);
                return static::hasReflectionAccess($method, $access);
            }
            return true;
        }

        return false;
    }

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