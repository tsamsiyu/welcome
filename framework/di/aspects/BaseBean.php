<?php namespace welcome\di\aspects;

use welcome\di\BeanableTrait;
use welcome\di\beans\IBeanable;
use welcome\di\ProxiableTrait;
use welcome\WObject;

/**
 * Class BaseBean
 * @package welcome\di\aspects
 */
class BaseBean extends WObject implements IBeanable
{
    use BeanableTrait;

    protected $_internal;
    protected $_external;

    public function __construct()
    {
        parent::__construct();
        $this->_internal = new ClassCurator($this, true);
        $this->_external = new ClassCurator($this, false);
    }

    protected function staticCall($name, array $arguments = [])
    {
        return call_user_func_array([ClassCurator::in(static::class, true), $name], $arguments);
    }

    public function __get($name)
    {
        return $this->_external->$name;
    }

    public function __set($name, $value)
    {
        $this->_external->$name = $value;
    }

    public function __call($name, array $arguments)
    {
        return call_user_func_array([$this->_external, $name], $arguments);
    }

    public static function __callStatic($name, array $arguments)
    {
        return call_user_func_array([ClassCurator::in(static::class), $name], $arguments);
    }

}