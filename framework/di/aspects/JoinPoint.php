<?php namespace welcome\di\aspects;

class JoinPoint
{
    const GET = '#get';
    const SET = '#set';
    const CALL = '#call';

    protected $_reflector;
    protected $_component;
    protected $_name;
    protected $_type;
    protected $_value;
    protected $_arguments;
    protected $_class;
    protected $_context = false;

    public function __construct(\ReflectionClass $reflector, $type, $name, $class, $context = false, IProxiable $component = null)
    {
        $this->_component = $component;
        $this->_reflector = $reflector;
        $this->_name = $name;
        $this->_type = $type;
        $args = func_get_args();
        if ($type === self::SET) {
            if (!isset($args[4])) {
                throw new \InvalidArgumentException("Value of property `$name` must be set.");
            }
            $this->_value = $args[4];
        } elseif ($type === self::CALL) {
            if (!isset($args[4])) {
                $this->_arguments = [];
            } elseif (is_array($args[4])) {
                $this->_arguments = $args[4];
            } else {
                throw new \InvalidArgumentException("Invalid arguments for `$name`");
            }
        } elseif ($type !== self::GET) {
            throw new \InvalidArgumentException('Type is invalid.');
        }
    }

    public function initiate()
    {
        if ($this->_type === self::SET) {
            $prop = $this->_reflector->getProperty($this->_name);
            if ($prop->isPublic()) {
                $this->_component->setIt($this->_name, $this->_value);
            } else {
                if (!$this->_context) {
                    throw new \Exception("Undefined property `{$this->_name}` in `{$this->_class}`");
                }
                $prop->setValue($this->_component, $this->_value);
            }
        } elseif ($this->_type === self::GET) {
            $prop = $this->_reflector->getProperty($this->_name);
            if ($prop->isPublic()) {
                return $this->_component->getIt($this->_name);
            } else {
                if (!$this->_context) {
                    throw new \Exception("Undefined property `{$this->_name}` in `{$this->_class}`");
                }
                return $prop->getValue($this->_component);
            }
        } elseif ($this->_type === self::CALL) {
            $method = $this->_reflector->getMethod($this->_name);
            if (!$this->_component) {
                if (!$method->isStatic()) {
                    throw new \InvalidArgumentException("It is impossible to call an object method from the context of the class. (Method `{$method->name}` in {$method->class})");
                }
                if ($method->isPublic()) {
                    /* @var IProxiable $c - namespace of class */
                    $c = get_class($this->_component);
                    return $c::callItStatically($this->_name, $this->_arguments);
                } else {
                    if (!$this->_context) {
                        throw new \Exception("Undefined method `{$this->_name}` in `{$this->_class}`");
                    }
                    return $method->invokeArgs(null, $this->_arguments);
                }
            } else {
                if ($method->isStatic()) {
                    throw new \InvalidArgumentException("It is impossible to call an class method from the context of the object. (Method `{$method->name}` in {$method->class})");
                }
                if ($method->isPublic()) {
                    return $this->_component->callIt($this->_name, $this->_arguments);
                } else {
                    if (!$this->_context) {
                        throw new \Exception("Undefined method `{$this->_name}` in `{$this->_class}`");
                    }
                    return $method->invokeArgs($this->_component, $this->_arguments);
                }
            }
        }

        return null;
    }

    public function getClass()
    {
        return $this->_class;
    }

    public function getComponent()
    {
        return $this->_component;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getNewValue()
    {
        return $this->_value;
    }

    public function setNewValue($newValue)
    {
        $this->_value = $newValue;
    }

    public function getInvokedArguments()
    {
        return $this->_arguments;
    }

    public function setInvokedArguments(array $arguments)
    {
        $this->_arguments = $arguments;
    }

    public function mergeInvokedArguments(array $arguments)
    {
        $this->_arguments = array_merge($this->_arguments, $arguments);
    }

}